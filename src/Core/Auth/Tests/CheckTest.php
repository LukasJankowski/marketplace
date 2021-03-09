<?php

namespace Marketplace\Core\Auth\Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Marketplace\Core\Data\Customer\Customer;
use Tests\TestCase;

class CheckTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCheckStatusIfAuthenticated()
    {
        $u = User::factory()->create(['type' => Customer::class]);

        $this->actingAs($u)->getJson(route('marketplace.core.auth.check'))
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
