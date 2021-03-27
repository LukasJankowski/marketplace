<?php

namespace Marketplace\Foundation\DataTransferObjects;

interface HasDtoFactory
{
    /**
     * Return the data as DTO.
     *
     * @return DataTransferObjectInterface
     */
    public function asDto(): DataTransferObjectInterface;
}
