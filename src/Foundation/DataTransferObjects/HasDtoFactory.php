<?php

namespace Marketplace\Foundation\DataTransferObjects;

interface HasDtoFactory
{
    /**
     * Return the data as DTO.
     */
    public function asDto(): DataTransferObjectInterface;
}
