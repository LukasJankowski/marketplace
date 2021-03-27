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
     * Check if the attribute can be created by us.
     *
     * @return bool
     */
    private function isMakeable(): bool
    {
        return !empty($this->reflectionProperty->getAttributes(Automake::class));
    }

    /**
     * Setter.
     *
     * @param mixed $value
     */
    public function setValue(mixed $value): void
    {
        /** @var \ReflectionNamedType $type */
        $type = $this->reflectionProperty->getType();
        $typeClass = $type->getName();
        if (!$type->isBuiltin()
            && $this->isMakeable()
            && !$value instanceof $typeClass
            && !($value === null && $type->allowsNull())
        ) {
            $value = $typeClass::make($value);
        }

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
