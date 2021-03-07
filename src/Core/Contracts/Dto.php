<?php


namespace Marketplace\Core\Contracts;


interface Dto
{
    /**
     * Create an instance of the DTO object.
     */
    public static function create(): self;
}
