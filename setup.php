<?php

declare(strict_types=1);

// Переменные окружения.
$env = [];
$envRaw = file_get_contents(__DIR__ . '/.env');
foreach (explode(PHP_EOL, $envRaw) as $line) {
    $data = explode('=', $line, 2);
    $key = trim((string)($data[0] ?? ''));

    if ('' !== $key && false === str_starts_with($key, '#')) {
        $value = trim((string)($data[1] ?? ''));
        $env[$key] = $value;
    }
}
$env = (object)$env;

// Клиент mysql.
$db = new \PDO(
    sprintf('mysql:unix_socket=%s', $env->DB_SOCKET),
    'root',
    '',
    [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_PERSISTENT => true,
        \PDO::ATTR_EMULATE_PREPARES => true,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
        \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    ]
);

/**
 * Создание пользователя mysql и пустой базы для приложения.
 */
$db->exec(
    "CREATE DATABASE IF NOT EXISTS {$env->DB_DATABASE} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
);
$stm = $db->prepare('SELECT COUNT(*) FROM mysql.user WHERE user=:user');
$stm->execute([':user' => $env->DB_USERNAME]);
if (0 === (int)$stm->fetchColumn()) {
    $db->exec(
        "CREATE DATABASE IF NOT EXISTS {$env->DB_DATABASE} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
        . "CREATE USER '{$env->DB_USERNAME}'@'%' IDENTIFIED BY '{$env->DB_PASSWORD}';"
        . "GRANT ALL PRIVILEGES ON {$env->DB_DATABASE}.* TO '{$env->DB_USERNAME}'@'%' IDENTIFIED BY '{$env->DB_PASSWORD}';"
        . 'FLUSH PRIVILEGES;'
    );
}


