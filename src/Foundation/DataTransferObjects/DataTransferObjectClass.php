<?php

namespace Marketplace\Foundation\DataTransferObjects;

use ReflectionClass;
use ReflectionProperty;

class DataTransferObjectClass
{
    /**
     * @var ReflectionClass
     */
    private ReflectionClass $reflectionClass;

    /**
     * @var DataTransferObject
     */
    private DataTransferObject $dataTransferObject;

    /**
     * DataTransferObjectClass constructor.
     *
     * @param DataTransferObject $dataTransferObject
     */
    public function __construct(DataTransferObject $dataTransferObject)
    {
        $this->reflectionClass = new ReflectionClass($dataTransferObject);
        $this->dataTransferObject = $dataTransferObject;
    }

    /**
     * @return DataTransferObjectProperty[]
     */
    public function getProperties(): array
    {
        $publicProperties = array_filter(
            $this->reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC),
            fn (ReflectionProperty $property) => ! $property->isStatic()
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
