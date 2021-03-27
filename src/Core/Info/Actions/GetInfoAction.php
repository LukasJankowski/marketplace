<?php

namespace Marketplace\Core\Info\Actions;

use Illuminate\Support\Env;
use Marketplace\Core\Info\Resources\InfoResource;
use Marketplace\Core\Logging\Logger;
use Marketplace\Foundation\Actions\BaseAction;

class GetInfoAction extends BaseAction
{
    /**
     * GetInfoAction constructor.
     */
    public function __construct(private Logger $logger)
    {
    }

    /**
     * Get the basic marketplace info.
     */
    public function run(): InfoResource
    {
        $this->logger->info('Info requested');

        return $this->respond(
            InfoResource::class,
            [
                'name' => Env::get('APP_NAME'),
                'version' => Env::get('APP_VERSION'),
                'base_url' => Env::get('APP_URL'),
            ]
        );
    }
}
