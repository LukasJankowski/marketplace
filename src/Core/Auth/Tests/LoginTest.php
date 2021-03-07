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
    private function loginTest($type, $routeKey): array
    {
        $user = User::factory()->create(['type' => $type]);

        $response = $this->postJson(
            route('marketplace.core.auth.' . $routeKey . '.login'),
            ['email' => $user->email, 'password' => 'password']
        );

        // The API updates the token after each login, therefore we have to refresh it.
        $user->refresh();

        return [$response, $user];
    }

    public function testCanLoginAllUserTypes()
    {
        [$r, $u] = $this->loginTest(Customer::class, 'customer');
        $r->assertStatus(200);
        $r->assertJsonPath('data.token', $u->api_token);

        [$r, $u] = $this->loginTest(Provider::class, 'provider');
        $r->assertStatus(200);
        $r->assertJsonPath('data.token', $u->api_token);

        [$r, $u] = $this->loginTest(Admin::class, 'admin');
        $r->assertStatus(200);
        $r->assertJsonPath('data.token', $u->api_token);
    }

    public function testCantLoginWithMismatchingTypes()
    {
        [$r, $u] = $this->loginTest(Admin::class, 'customer');
        $r->assertStatus(403);
        $r->assertJsonPath('data.message', 'marketplace.core.auth.login.failed');
    }

    public function testCantLoginWithInvalidCredentials()
    {
        $this->postJson(
            route('marketplace.core.auth.customer.login'),
            ['email' => 'test@test.com', 'password' => 'password']
        )
            ->assertStatus(403)
            ->assertJsonPath('data.message', 'marketplace.core.auth.login.failed');
    }

    public function testCantLoginWithInsufficientCredentials()
    {
        $this->postJson(
            route('marketplace.core.auth.customer.login'),
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
                route('marketplace.core.auth.customer.login'),
                ['email' => 'test@test.com', 'password' => 'password']
            )
                ->assertStatus(403)
                ->assertJsonPath('data.message', 'marketplace.core.auth.login.failed');
        }

        $this->postJson(
            route('marketplace.core.auth.customer.login'),
            ['email' => 'test@test.com', 'password' => 'password']
        )->assertStatus(429);
    }
}
