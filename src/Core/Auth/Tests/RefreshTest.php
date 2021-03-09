<?php

namespace Marketplace\Core\Auth\Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Marketplace\Core\Data\Customer\Customer;
use Tests\TestCase;

class RefreshTest extends TestCase
{
    use RefreshDatabase;

    public function testCanRefreshTokenIfAuthenticated()
    {
        $u = User::factory()->create(['type' => Customer::class]);

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
