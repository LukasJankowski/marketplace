<?php

namespace Marketplace\Core\Auth\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Marketplace\Foundation\Tests\TestsHelperTrait;
use Tests\TestCase;

class CheckTest extends TestCase
{
    use RefreshDatabase;
    use TestsHelperTrait;

    public function testCanCheckStatusIfAuthenticated()
    {
        $u = $this->getUser();

        $this->actingAs($u, 'api')->getJson(route('marketplace.core.auth.check'))
            ->assertStatus(200)
            ->assertJsonPath('data.token', $u->api_token);
    }

    public function testCanCheckStatusIfAuthenticatedManually()
    {
        $u = $this->getUser();

        $this->withHeader('Authorization', 'Bearer ' . $u->api_token)
            ->getJson(route('marketplace.core.auth.check'))
            ->assertStatus(200)
            ->assertJsonPath('data.token', $u->api_token);
    }

    public function testCantCheckStatusIfNotAuthenticated()
    {
        $this->getJson(route('marketplace.core.auth.check'))
            ->assertStatus(401)
            ->assertJsonPath('data.message', 'marketplace.core.authentication.unauthenticated');
    }
}
