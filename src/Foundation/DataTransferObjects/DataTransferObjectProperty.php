<?php

namespace Marketplace\Foundation\DataTransferObjects;

use ReflectionProperty;

class DataTransferObjectProperty
{
    /**
     * @var string
     */
    public string $name;

    /**
     * DataTransferObjectProperty constructor.
     *
     * @param DataTransferObject $dataTransferObject
     * @param ReflectionProperty $reflectionProperty
     */
    public function __construct(
        private DataTransferObject $dataTransferObject,
        private ReflectionProperty $reflectionProperty
    ) {
        $this->name = $this->reflectionProperty->name;
    }

    /**
     * Setter.
     *
     * @param mixed $value
     */
    public function setValue(mixed $value): void
    {
        $this->reflectionProperty->setValue($this->dataTransferObject, $value);
    }

    /**
     * Getter.
     *
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->reflectionProperty->getValue($this->dataTransferObject);
    }
}
