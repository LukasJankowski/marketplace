<?php

namespace Marketplace\Foundation\DataTransferObjects;

use ReflectionProperty;

class DataTransferObjectProperty
{
    public string $name;

    /**
     * DataTransferObjectProperty constructor.
     */
    public function __construct(
        private DataTransferObject $dataTransferObject,
        private ReflectionProperty $reflectionProperty
    ) {
        $this->name = $this->reflectionProperty->name;
    }

    /**
     * Check if the attribute can be created by us.
     */
    private function isMakeable(): bool
    {
        return !empty($this->reflectionProperty->getAttributes(Automake::class));
    }

    /**
     * Setter.
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
     */
    public function getValue(): mixed
    {
        return $this->reflectionProperty->getValue($this->dataTransferObject);
    }
}
