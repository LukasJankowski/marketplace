<?php

namespace Marketplace\Core\Auth\Password;

use Marketplace\Foundation\Exceptions\ExceptionHelperTrait;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UpdatePasswordException extends HttpException
{
    use ExceptionHelperTrait;

    /**
     * UpdatePasswordException constructor.
     *
     * @param int $status
     * @param string|null $exceptionMessage
     * @param \Throwable|null $previous
     * @param array<string, mixed> $headers
     * @param int|null $code
     */
    public function __construct(
        private int $status = 403,
        private ?string $exceptionMessage = 'marketplace.core.auth.password.invalid',
        ?\Throwable $previous = null,
        array $headers = [],
        ?int $code = 0
    )
    {
        parent::__construct($this->status, $this->exceptionMessage, $previous, $headers, $code);
    }
}
