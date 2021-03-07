<?php


namespace Marketplace\Core\Actions;


class GetInfoAction
{
    /**
     * Get the basic marketplace info.
     *
     * @return array
     */
    public function run(): array
    {
        return [
            'name' => env('APP_NAME'),
            'version' => env('APP_VERSION'),
            'base_url' => env('APP_URL'),
        ];
    }
}
