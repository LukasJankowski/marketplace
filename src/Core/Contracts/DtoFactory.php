<?php


namespace Marketplace\Core\Contracts;


interface DtoFactory
{
    /**
     * Create a DTO.
     *
     * @return Dto
     */
    public function getDto();
}
