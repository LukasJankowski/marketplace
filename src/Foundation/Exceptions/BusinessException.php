<?php

namespace Marketplace\Foundation\Exceptions;

class BusinessException extends \Exception
{
    /**
     * @var string
     */
    private string $businessMessage;

    /**
     * BusinessException constructor.
     *
     * @param  string  $businessMessage
     * @param  int  $code
     * @param  \Throwable|null  $previous
     */
    public function __construct(string $businessMessage, $code = 0, \Throwable $previous = null)
    {
        $this->businessMessage = $businessMessage;
        parent::__construct('marketplace.core.error.business', $code, $previous);
    }

    /**
     * Get the specific message regarding the error.
     *
     * @return string
     */
    public function getBusinessMessage(): string
    {
        return $this->businessMessage;
    }
}
