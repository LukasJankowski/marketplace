<?php

namespace Marketplace\Foundation\Logging;

use Illuminate\Log\LogManager;
use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface
{
    /**
     * Create a new Log manager instance.
     *
     * @param LogManager $logger
     */
    public function __construct(private LogManager $logger) {}

    /**
     * Set additional information in the context
     *
     * @param array $context
     * @return array
     */
    private function addMetaInfo(array $context = []): array
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
        $this->logger->emergency($message, $this->addMetaInfo($context));
    }

    /**
     * @inheritDoc
     */
    public function alert($message, array $context = [])
    {
        $this->logger->emergency($message, $this->addMetaInfo($context));
    }

    /**
     * @inheritDoc
     */
    public function critical($message, array $context = [])
    {
        $this->logger->emergency($message, $this->addMetaInfo($context));
    }

    /**
     * @inheritDoc
     */
    public function error($message, array $context = [])
    {
        $this->logger->error($message, $this->addMetaInfo($context));
    }

    /**
     * @inheritDoc
     */
    public function warning($message, array $context = [])
    {
        $this->logger->warning($message, $this->addMetaInfo($context));
    }

    /**
     * @inheritDoc
     */
    public function notice($message, array $context = [])
    {
        $this->logger->notice($message, $this->addMetaInfo($context));
    }

    /**
     * @inheritDoc
     */
    public function info($message, array $context = [])
    {
        $this->logger->info($message, $this->addMetaInfo($context));
    }

    /**
     * @inheritDoc
     */
    public function debug($message, array $context = [])
    {
        $this->logger->debug($message, $this->addMetaInfo($context));
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = [])
    {
        $this->logger->log($level, $message, $this->addMetaInfo($context));
    }
}
