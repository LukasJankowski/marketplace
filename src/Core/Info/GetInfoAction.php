<?php

namespace Marketplace\Core\Info;

use Illuminate\Support\Env;
use Marketplace\Foundation\Logging\Logger;

class GetInfoAction
{
    /**
     * GetInfoAction constructor.
     *
     * @param Logger $logger
     */
    public function __construct(private Logger $logger) {}

    /**
     * Get the basic marketplace info.
     *
     * @return array<string, string>
     */
    public function run(): array
    {
        $this->logger->info('Info requested');

        return [
            'name' => Env::get('APP_NAME'),
            'version' => Env::get('APP_VERSION'),
            'base_url' => Env::get('APP_URL'),
        ];
    }
}
