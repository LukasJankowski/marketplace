<?php

namespace Marketplace\Core\Logging;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Log\LogManager;
use Psr\Log\LoggerInterface;
use Stringable;

class Logger implements LoggerInterface
{
    /**
     * Logger constructor.
     */
    public function __construct(private LogManager $logger, private Application $application)
    {
    }

    /**
     * @inheritDoc
     */
    public function emergency($message, array $context = [])
    {
        $this->logger->emergency($message, $this->addMetaInfo($context));
    }

    /**
     * Set additional information in the context
     *
     * @param array<string, mixed> $context
     *
     * @return array<string, mixed>
     */
    private function addMetaInfo(array $context = []): array
    {
        if ($this->application->runningInConsole()) {
            $causer = 'console';
        } else {
            $request = $this->application->make(Request::class);
            $causer = $request->user() !== null ? $request->user()->getAuthIdentifier() : $request->ip();
        }

        return $this->convertStringableContexts($context) + ['causer' => $causer];
    }

    /**
     * Convert all stringable objects to string.
     *
     * @param array<string, mixed> $contexts
     *
     * @return array
     */
    private function convertStringableContexts(array $contexts): array
    {
        foreach ($contexts as &$context) {
            if ($context instanceof Stringable) {
                $context = (string) $context;
            }
        }

        return $contexts;
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
