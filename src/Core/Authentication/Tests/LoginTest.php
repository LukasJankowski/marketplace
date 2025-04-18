<?php

namespace Marketplace\Core\Authentication\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Marketplace\Core\Authentication\Events\UserLoggedIn;
use Marketplace\Core\Authorization\RoleService;
use Marketplace\Foundation\Tests\TestsHelperTrait;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use TestsHelperTrait;

    /**
     * Test for each type given.
     */
    private function loginTest(string $role): array
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
     */
    private function getRoute(string $role): string
    {
        return route('marketplace.core.authentication.login', ['role' => $role]);
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
        $user = $this->getUser(['role' => 'admin']);

        $this->postJson(
            $this->getRoute('customer'),
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertStatus(403)
            ->assertJsonPath('data.message', 'marketplace.core.authentication.login.failed');
    }

    public function testCantLoginWithInvalidCredentials()
    {
        $this->postJson(
            $this->getRoute('customer'),
            ['email' => 'test@test.com', 'password' => 'password']
        )
            ->assertStatus(403)
            ->assertJsonPath('data.message', 'marketplace.core.authentication.login.failed');
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
                ->assertJsonPath('data.message', 'marketplace.core.authentication.login.failed');
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
