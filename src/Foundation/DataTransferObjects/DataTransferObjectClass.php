<?php

namespace Marketplace\Foundation\DataTransferObjects;

use ReflectionClass;
use ReflectionProperty;

class DataTransferObjectClass
{
    private ReflectionClass $reflectionClass;

    private DataTransferObject $dataTransferObject;

    /**
     * DataTransferObjectClass constructor.
     */
    public function __construct(DataTransferObject $dataTransferObject)
    {
        $this->reflectionClass = new ReflectionClass($dataTransferObject);
        $this->dataTransferObject = $dataTransferObject;
    }

    /**
     * @return array<DataTransferObjectProperty>
     */
    public function getProperties(): array
    {
        $publicProperties = array_filter(
            $this->reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC),
            fn (ReflectionProperty $property) => !$property->isStatic()
        );

        return array_map(
            fn (ReflectionProperty $property) => new DataTransferObjectProperty(
                $this->dataTransferObject,
                $property
            ),
            $publicProperties
        );
    }
}
