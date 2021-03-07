<?php

namespace Marketplace\Foundation\Contracts;

interface DtoFactory
{
    /**
     * Create a DTO.
     *
     * @return Dto
     */
    public function getDto();
}
