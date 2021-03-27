<?php

namespace Marketplace\Foundation\Models;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class BaseCast implements CastsAttributes
{
    /**
     * BaseCast constructor.
     */
    public function __construct(protected string $valueObject)
    {
    }

    /**
     * Check if valid instance.
     */
    public function checkValidInstance(string $class, mixed $value): void
    {
        if (!$value instanceof $class) {
            throw new \InvalidArgumentException(
                sprintf('The given value is not a valid instance of %s.', $class)
            );
        }
    }

    /**
     * Check for the existence of the valueObject.
     */
    private function checkValueObject(): void
    {
        if (!class_exists($this->valueObject)) {
            throw new \RuntimeException(
                'Default cast requires protected property $valueObject'
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes): mixed
    {
        $this->checkValueObject();

        return $this->valueObject::make($attributes[$key]);
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes): array
    {
        $this->checkValueObject();
        $this->checkValidInstance($this->valueObject, $value);

        return [$key => $value->value()];
    }
}
