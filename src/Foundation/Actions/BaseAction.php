<?php

namespace Marketplace\Foundation\Actions;

use LogicException;

abstract class BaseAction
{
    /**
     * Make a response.
     *
     * @param string $resource
     * @param mixed $data
     * @param bool $isMany
     *
     * @return mixed
     */
    protected function respond(string $resource, mixed $data, bool $isMany = false): mixed
    {
        if (!class_exists($resource)) {
            throw new LogicException(
                sprintf('The resource: %s does not exist.', $resource)
            );
        }

        return $isMany ? $resource::collection($data) : $resource::make($data);
    }
}
