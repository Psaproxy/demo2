#!/usr/bin/make
SHELL=/bin/sh

# Эксперементальная сборка с запуском сервисов контейнеров от текущего пользователя host системы.

USER_NAME := $(shell id -un)
USER_ID := $(shell id -u)
GROUP_ID := $(shell id -g)

export USER_NAME
export USER_ID
export GROUP_ID

docker := $(shell command -v docker 2> /dev/null)
docker_compose := $(shell command -v docker-compose 2> /dev/null)

mysql_container_name = demo-mysql
cli_container_name = demo-cli

# Запуск всех контейнеров
up:
	chmod 777 -R docker/data
	$(docker_compose) up -d --no-recreate

# Остановка всех контейнеров
down:
	$(docker_compose) down --remove-orphans

build_:
	$(docker_compose) build

# Пересборка всех контейнеров
build: down build_ up

# Перезапуск всех контейнеров
restart:
	chmod 777 -R docker/data
	$(docker_compose) restart

# Консоль mysql
mysql: up
	$(docker) exec -it -u $(shell id -u) $(mysql_container_name) mysql -u root

# Выполнение CLI-команды PHP. Пример: make php ARGS=install.php
php: up
	$(docker) exec -it -u $(shell id -u) $(cli_container_name) php $(ARGS)

# Выполнение CLI-команды приложения. Пример: make cli ARGS=migrate:status
cli: up
	$(docker) exec -it -u $(shell id -u) $(cli_container_name) php yii $(ARGS)

# Выполнение команды npm. Пример: make npm ARGS="install --save laravel-echo pusher-js"
npm: up
	$(docker) exec -it -u $(shell id -u) $(cli_container_name) npm $(ARGS)

# Выполнение команды npm. Пример: make npm ARGS=dev
npm-run: up
	$(docker) exec -it -u $(shell id -u) $(cli_container_name) npm run $(ARGS)

# Выполнение команды composer. Например: make composer ARGS=dump-autoload
composer: up
	$(docker) exec -it -u $(shell id -u) $(cli_container_name) composer $(ARGS)

# Установка и настройка приложения
install_:
	$(docker) exec -it -u $(shell id -u) $(cli_container_name) composer install

install: up install_ setup

# Настройка приложения
setup: up
	$(docker) exec -it -u $(shell id -u) $(cli_container_name) bash -c "php setup.php && php yii migrate --interactive=0"

# Запуск всех тестов
test: up test-unit test-feature test-phpstan test-phpcs

# Запуск модульных тестов
# Аргументы phpunit в ARGS="..". Пример: make test ARGS="--filter ExampleTest"
test-unit: up
	$(docker) exec -it -u $(USER_ID) "$(cli_container_name)" composer test-phpunit -- --testsuite=Unit $(ARGS)

# Запуск функциональных тестов
# Аргументы phpunit в ARGS="..". Пример: make test ARGS="--filter ExampleTest"
test-feature: up
	$(docker) exec -it -u $(USER_ID) "$(cli_container_name)" composer test-phpunit -- --testsuite=Feature $(ARGS)

test-phpstan: up
	$(docker) exec -it -u $(USER_ID) "$(cli_container_name)" composer test-phpstan -- $(ARGS)

test-phpcs: up
	$(docker) exec -it -u $(USER_ID) "$(cli_container_name)" composer test-phpcs -- $(ARGS)

test-deptrac: up
	$(docker) exec -it -u $(USER_ID) "$(cli_container_name)" composer test-deptrac -- $(ARGS)
