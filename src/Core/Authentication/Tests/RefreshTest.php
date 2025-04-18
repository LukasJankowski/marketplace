<?php

namespace Marketplace\Core\Authentication\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Marketplace\Foundation\Tests\TestsHelperTrait;
use Tests\TestCase;

class RefreshTest extends TestCase
{
    use RefreshDatabase;
    use TestsHelperTrait;

    public function testCanRefreshTokenIfAuthenticated()
    {
        $u = $this->getUser();

        $this->actingAs($u)->getJson(route('marketplace.core.authentication.refresh'))
            ->assertStatus(200)
            ->assertJsonPath('data.token', $u->api_token);
    }

    public function testCantRefreshIfNotAuthenticated()
    {
        $this->getJson(route('marketplace.core.authentication.check'))
            ->assertStatus(401)
            ->assertJsonPath('data.message', 'marketplace.core.authentication.unauthenticated');
    }
}
