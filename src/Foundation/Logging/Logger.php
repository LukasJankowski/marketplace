<?php

namespace Marketplace\Foundation\Logging;

use Illuminate\Http\Request;
use Illuminate\Log\LogManager;
use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface
{
    /**
     * Create a new Log manager instance.
     *
     * @param LogManager $logger
     * @param Request $request
     */
    public function __construct(
        private LogManager $logger,
        private Request $request
    ) {}

    /**
     * Set additional information in the context
     *
     * @param array $context
     * @return array
     */
    private function setContext(array $context = []): array
    {
        return $context + [
            'causer' => optional($this->request->user())->getAuthIdentifier() ?? $this->request->ip(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function emergency($message, array $context = [])
    {
        $this->logger->emergency($message, $this->setContext($context));
    }

    /**
     * @inheritDoc
     */
    public function alert($message, array $context = [])
    {
        $this->logger->emergency($message, $this->setContext($context));
    }

    /**
     * @inheritDoc
     */
    public function critical($message, array $context = [])
    {
        $this->logger->emergency($message, $this->setContext($context));
    }

    /**
     * @inheritDoc
     */
    public function error($message, array $context = [])
    {
        $this->logger->error($message, $this->setContext($context));
    }

    /**
     * @inheritDoc
     */
    public function warning($message, array $context = [])
    {
        $this->logger->warning($message, $this->setContext($context));
    }

    /**
     * @inheritDoc
     */
    public function notice($message, array $context = [])
    {
        $this->logger->notice($message, $this->setContext($context));
    }

    /**
     * @inheritDoc
     */
    public function info($message, array $context = [])
    {
        $this->logger->info($message, $this->setContext($context));
    }

    /**
     * @inheritDoc
     */
    public function debug($message, array $context = [])
    {
        $this->logger->debug($message, $this->setContext($context));
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = [])
    {
        $this->logger->log($level, $message, $this->setContext($context));
    }
}
