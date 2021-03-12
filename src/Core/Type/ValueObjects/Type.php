<?php

namespace Marketplace\Core\Type\ValueObjects;

use Marketplace\Core\Type\TypeService;

class Type
{
    /**
     * Type constructor.
     *
     * @param string $type
     */
    private function __construct(private string $type) {}

    /**
     * Create a new instance of self.
     *
     * @param string $type
     *
     * @return self
     */
    public static function make(string $type): self
    {
        if (!TypeService::keyExists($type)) {
            throw new \InvalidArgumentException(
                sprintf('Unknown type: %s', $type)
            );
        }

        return new self($type);
    }

    /**
     * Get the type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get the class of type.
     *
     * @return string
     */
    public function getClass(): string
    {
        return TypeService::getClassByKey($this->type);
    }
}
