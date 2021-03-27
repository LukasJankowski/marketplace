<?php

namespace Marketplace\Foundation\Exceptions;

use Illuminate\Http\JsonResponse;
use Marketplace\Foundation\Resources\ErrorResource;

trait ExceptionHelperTrait
{
    /**
     * Render response of the exception
     */
    public function render(): JsonResponse
    {
        return ErrorResource::make(
            [
                'message' => $this->getMessage(),
                'errors' => $this->getErrors(),
            ]
        )
            ->response()
            ->setStatusCode($this->getStatus());
    }

    /**
     * Get the errors.
     *
     * @return array<mixed>
     */
    private function getErrors(): array
    {
        if (method_exists($this, 'errors')) {
            $errors = $this->errors();
        }

        return $errors ?? [];
    }

    /**
     * Get the status.
     */
    private function getStatus(): int
    {
        if (property_exists($this, 'status')) {
            $status = $this->status;
        }

        return $status ?? 400;
    }
}
