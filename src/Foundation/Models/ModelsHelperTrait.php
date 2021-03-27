<?php

namespace Marketplace\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Marketplace\Foundation\ValueObjects\ValueObject;

trait ModelsHelperTrait
{
    /**
     * Create helper.
     *
     * @param array $attributes
     *
     * @return Model
     */
    public static function create(array $attributes): Model
    {
        foreach ($attributes as $key => $attribute) {
            if ($attribute instanceof ValueObject) {
                $attribute = $attribute->value();
            }

            $attributes[Str::snake($key)] = $attribute;
        }

        return self::query()->create($attributes);
    }
}
