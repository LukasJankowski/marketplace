<?php

namespace Marketplace\Core\Auth\Tests;

use Marketplace\Core\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCheckStatusIfAuthenticated()
    {
        $u = User::factory()->create(['type' => 'customer']);

        $this->actingAs($u, 'api')->getJson(route('marketplace.core.auth.check'))
            ->assertStatus(200)
            ->assertJsonPath('data.token', $u->api_token);
    }

    public function testCanCheckStatusIfAuthenticatedManually()
    {
        $u = User::factory()->create(['type' => 'customer']);

        $this->withHeader('Authorization', 'Bearer ' . $u->api_token)
            ->getJson(route('marketplace.core.auth.check'))
            ->assertStatus(200)
            ->assertJsonPath('data.token', $u->api_token);
    }

    public function testCantCheckStatusIfNotAuthenticated()
    {
        $this->getJson(route('marketplace.core.auth.check'))
            ->assertStatus(403)
            ->assertJsonPath('data.message', 'marketplace.core.auth.login.failed');
    }
}
