<?php

namespace Marketplace\Core\Auth\Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Marketplace\Core\Data\Admin\Admin;
use Marketplace\Foundation\Services\TypeService;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Get the route.
     *
     * @param $type
     *
     * @return string
     */
    private function getRoute($type)
    {
        return route('marketplace.core.auth.login', ['type' => $type]);
    }

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
        $model = TypeService::getClassByKey($type);

        $user = User::factory()->create(['type' => $model]);

        $response = $this->postJson(
            $this->getRoute($type),
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
        $user = User::factory()->create(['type' => Admin::class]);

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
}
