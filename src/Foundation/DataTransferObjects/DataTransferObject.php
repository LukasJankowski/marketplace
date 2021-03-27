<?php

namespace Marketplace\Foundation\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;
use Stringable;

abstract class DataTransferObject implements Stringable, Arrayable, DataTransferObjectInterface
{
    private DataTransferObjectClass $class;

    /**
     * DataTransferObject constructor.
     *
     * @param ...array
     */
    public function __construct(...$args)
    {
        if (is_array($args[0] ?? null)) {
            $args = $args[0];
        }

        $this->class = new DataTransferObjectClass($this);

        foreach ($this->class->getProperties() as $property) {
            $property->setValue($args[$property->name] ?? null);
        }
    }

    /**
     * Convert DTO to string.
     */
    public function __toString(): string
    {
        $props = array_map(
            fn ($prop) => $prop instanceof Stringable ? (string) $prop : $prop,
            $this->toArray()
        );

        return json_encode($props);
    }

    /**
     * Convert DTO to array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $properties = [];
        foreach ($this->class->getProperties() as $property) {
            $properties[$property->name] = $property->getValue();
        }

        return $properties;
    }
}
