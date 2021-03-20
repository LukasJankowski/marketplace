<?php

namespace Marketplace\Core\Auth\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Marketplace\Core\Auth\Login\UserLoggedIn;
use Marketplace\Core\Role\RoleService;
use Marketplace\Foundation\Tests\TestsHelperTrait;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use TestsHelperTrait;

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

    /**
     * Test for each type given.
     *
     * @param $role
     * @param $routeKey
     *
     * @return array
     */
    private function loginTest($role): array
    {
        $model = RoleService::getRoleBySlug($role);

        $user = $this->getUser(['role' => $model]);

        $response = $this->postJson(
            $this->getRoute($role),
            ['email' => $user->email, 'password' => 'password']
        );

        // The API updates the token after each login, therefore we have to refresh it.
        $user->refresh();

        return [$response, $user];
    }

    /**
     * Get the route.
     *
     * @param $role
     *
     * @return string
     */
    private function getRoute($role): string
    {
        return route('marketplace.core.auth.login', ['role' => $role]);
    }

    public function testCantLoginWithMismatchingTypes()
    {
        $user = $this->getUser(['role' => 'admin']);

        $this->postJson(
            $this->getRoute('customer'),
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertStatus(403)
            ->assertJsonPath('data.message', 'marketplace.core.auth.login.failed');
    }

    public function testCantLoginWithInvalidCredentials()
    {
        $this->postJson(
            $this->getRoute('customer'),
            ['email' => 'test@test.com', 'password' => 'password']
        )
            ->assertStatus(403)
            ->assertJsonPath('data.message', 'marketplace.core.auth.login.failed');
    }

    public function testCantLoginWithInsufficientCredentials()
    {
        $this->postJson(
            $this->getRoute('customer'),
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
                $this->getRoute('customer'),
                ['email' => 'test@test.com', 'password' => 'password']
            )
                ->assertStatus(403)
                ->assertJsonPath('data.message', 'marketplace.core.auth.login.failed');
        }

        $this->postJson(
            $this->getRoute('customer'),
            ['email' => 'test@test.com', 'password' => 'password']
        )->assertStatus(429);
    }

    public function testCantLoginWithInvalidType()
    {
        $user = $this->getUser(['role' => 'admin']);

        $this->postJson(
            $this->getRoute('invalid-type'),
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertStatus(404);

        $this->postJson(
            $this->getRoute('customerprovider'),
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertStatus(404);

        $this->postJson(
            $this->getRoute('customer123'),
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertStatus(404);

        $this->postJson(
            $this->getRoute(' '),
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertStatus(404);

        $this->postJson(
            $this->getRoute('CuSTomErr'),
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertStatus(404);
    }

    public function testEventIsEmittedOnLogin()
    {
        Event::fake();

        [$r, $u] = $this->loginTest('customer');
        $r->assertStatus(200);
        $r->assertJsonPath('data.token', $u->api_token);

        Event::assertDispatched(
            UserLoggedIn::class,
            fn (UserLoggedIn $e) => $e->getUser()->getAuthIdentifier() === $u->getAuthIdentifier()
        );
    }
}
