<?php

namespace Marketplace\Core\Authentication\Exceptions;

use Marketplace\Foundation\Exceptions\ExceptionHelperTrait;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class UpdatePasswordException extends HttpException
{
    use ExceptionHelperTrait;

    /**
     * UpdatePasswordException constructor.
     *
     * @param array<string, mixed> $headers
     */
    public function __construct(
        private int $status = 403,
        private ?string $exceptionMessage = 'marketplace.core.authentication.password.invalid',
        ?Throwable $previous = null,
        array $headers = [],
        ?int $code = 0
    ) {
        parent::__construct($this->status, $this->exceptionMessage, $previous, $headers, $code);
    }
}
