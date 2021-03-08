<?php

namespace Marketplace\Core\Info\Tests;

use Tests\TestCase;

class GetInfoTest extends TestCase
{
    public function testGetExpectedInfo()
    {
        $response = $this->getJson(route('marketplace.core.info.dump'));

        $response->assertStatus(200);
        $response->assertJsonPath('data.name', env('APP_NAME'));
        $response->assertJsonPath('data.version', env('APP_VERSION'));
        $response->assertJsonPath('data.base_url', env('APP_URL'));
    }
}
