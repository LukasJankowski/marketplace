<?php

namespace Marketplace\Core\Info;

use Marketplace\Foundation\Logging\Logger;

class GetInfoAction
{
    public function __construct(private Logger $logger) {}

    /**
     * Get the basic marketplace info.
     *
     * @return array
     */
    public function run(): array
    {
        $this->logger->info('Info requested');

        return [
            'name' => env('APP_NAME'),
            'version' => env('APP_VERSION'),
            'base_url' => env('APP_URL'),
        ];
    }
}
