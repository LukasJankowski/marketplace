<?php

namespace Marketplace\Core\Auth\Tests;

use Marketplace\Core\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Marketplace\Foundation\Tests\TestsHelperTrait;
use Tests\TestCase;

class RefreshTest extends TestCase
{
    use RefreshDatabase, TestsHelperTrait;

    public function testCanRefreshTokenIfAuthenticated()
    {
        $u = $this->getUser();

        $this->actingAs($u)->getJson(route('marketplace.core.auth.refresh'))
            ->assertStatus(200)
            ->assertJsonPath('data.token', $u->api_token);
    }

    public function testCantRefreshIfNotAuthenticated()
    {
        $this->getJson(route('marketplace.core.auth.check'))
            ->assertStatus(403)
            ->assertJsonPath('data.message', 'marketplace.core.auth.login.failed');
    }
}
