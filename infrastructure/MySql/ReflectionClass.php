<?php

declare(strict_types=1);

namespace App\Infrastructure\MySql;

class ReflectionClass
{
    /**
     * @param string $className
     * @param array<string,mixed> $valuesOfProperties Ключ - имя свойства. Знак "$" из ключа будет удален.
     *  Стиль регитсра, snake_case или camelCase, значения не имеет, так как будет авто приведение к camelCase.
     *
     * @return object
     *
     * @throws \ReflectionException
     */
    public static function newInstanceWithoutConstructor(
        string $className,
        array $valuesOfProperties
    ): object
    {
        /** @var mixed $className */
        $reflection = new \ReflectionClass($className);
        $entity = $reflection->newInstanceWithoutConstructor();

        $values = [];

        foreach ($valuesOfProperties as $name => $value) {
            $name = str_replace('$', '', $name);
            $name = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $name))));

            if (false === $reflection->hasProperty($name)) {
                throw new \RuntimeException(
                    sprintf(
                        'Не найдено свойство "%s" у класса "%s". Может быть это приватное свойство родительского класса.',
                        $name,
                        $className
                    )
                );
            }

            $values[$name] = $value;
        }

        foreach ($reflection->getProperties() as $property) {
            $name = $property->getName();

            $propValuesNotExists = isset($values[$name]) || array_key_exists($name, $values);

            if (false === $propValuesNotExists) {
                continue;
            }

            $propValue = $values[$name] ?? null;

            $property->setAccessible(true);
            $property->setValue($entity, $propValue);
        }

        return $entity;
    }
}
