<?php

namespace Marketplace\Core\Auth\Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Marketplace\Core\Data\Models\Admin;
use Marketplace\Core\Data\Models\Customer;
use Marketplace\Core\Data\Models\Provider;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test for each type given.
     *
     * @param $type
     * @param $routeKey
     *
     * @return array
     */
    private function loginTest($type): array
    {
        $model = match ($type) {
            'customer' => Customer::class,
            'provider' => Provider::class,
            'admin' => Admin::class,
        };

        $user = User::factory()->create(['type' => $model]);

        $response = $this->postJson(
            route('marketplace.core.auth.login', ['type' => $type]),
            ['email' => $user->email, 'password' => 'password']
        );

        // The API updates the token after each login, therefore we have to refresh it.
        $user->refresh();

        return [$response, $user];
    }

    public function testCanLoginAllUserTypes()
    {
        [$r, $u] = $this->loginTest('customer');
        $r->assertStatus(200);
        $r->assertJsonPath('data.token', $u->api_token);

        [$r, $u] = $this->loginTest('provider');
        $r->assertStatus(200);
        $r->assertJsonPath('data.token', $u->api_token);

        [$r, $u] = $this->loginTest('admin');
        $r->assertStatus(200);
        $r->assertJsonPath('data.token', $u->api_token);
    }

    public function testCantLoginWithMismatchingTypes()
    {
        $user = User::factory()->create(['type' => Admin::class]);

        $this->postJson(
            route('marketplace.core.auth.login', ['type' => 'customer']),
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertStatus(403)
            ->assertJsonPath('data.message', 'marketplace.core.auth.login.failed');
    }

    public function testCantLoginWithInvalidCredentials()
    {
        $this->postJson(
            route('marketplace.core.auth.login', ['type' => 'customer']),
            ['email' => 'test@test.com', 'password' => 'password']
        )
            ->assertStatus(403)
            ->assertJsonPath('data.message', 'marketplace.core.auth.login.failed');
    }

    public function testCantLoginWithInsufficientCredentials()
    {
        $this->postJson(
            route('marketplace.core.auth.login', ['type' => 'customer']),
            ['email' => 'invalid-email', 'password' => 'short']
        )
            ->assertStatus(422)
            ->assertJsonPath('data.message', 'marketplace.core.validation.invalid')
            ->assertJsonPath('data.errors.email.0', 'marketplace.core.validation.email')
            ->assertJsonPath('data.errors.password.0', 'marketplace.core.validation.min:6');
    }

    public function testLoginGetsThrottledAfterXAttempts()
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson(
                route('marketplace.core.auth.login', ['type' => 'customer']),
                ['email' => 'test@test.com', 'password' => 'password']
            )
                ->assertStatus(403)
                ->assertJsonPath('data.message', 'marketplace.core.auth.login.failed');
        }

        $this->postJson(
            route('marketplace.core.auth.login', ['type' => 'customer']),
            ['email' => 'test@test.com', 'password' => 'password']
        )->assertStatus(429);
    }

    public function testCantLoginWithInvalidType()
    {
        $user = User::factory()->create(['type' => Admin::class]);

        $this->postJson(
            route('marketplace.core.auth.login', ['type' => 'invalid-type']),
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertStatus(404);

        $this->postJson(
            route('marketplace.core.auth.login', ['type' => 'customerprovider']),
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertStatus(404);

        $this->postJson(
            route('marketplace.core.auth.login', ['type' => 'customer123']),
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertStatus(404);

        $this->postJson(
            route('marketplace.core.auth.login', ['type' => ' ']),
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertStatus(404);

        $this->postJson(
            route('marketplace.core.auth.login', ['type' => 'CuSTomErr']),
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertStatus(404);
    }
}
