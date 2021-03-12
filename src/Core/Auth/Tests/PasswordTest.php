<?php

namespace Marketplace\Core\Auth\Tests;

use Marketplace\Core\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testCanUpdatePasswordOfUser()
    {
        $u = User::factory()->create();

        $url = URL::signedRoute('marketplace.core.auth.password', ['type' => 'customer', 'id' => $u->id]);

        $this->postJson($url, [
            'password' => 'another'
        ])
            ->assertStatus(200)
            ->assertJsonPath('data.id', $u->id);

        $u->refresh();

        $this->assertTrue(
            Hash::check('another', $u->password)
        );
    }

    public function testCantUpdatePasswordWithInvalidUrl()
    {
        $u = User::factory()->create();

        $url = URL::signedRoute('marketplace.core.auth.password', ['type' => 'customer', 'id' => $u->id]);
        $url = substr($url, 0, -6); // broken signature

        $this->postJson($url)
            ->assertStatus(401)
            ->assertJsonPath('data.message', 'marketplace.core.authorization.unauthorized');
    }

    public function testCantUpdatePasswordWithInvalidId()
    {
        $url = URL::signedRoute('marketplace.core.auth.password', ['type' => 'customer', 'id' => 1]);

        $this->postJson($url, ['password' => 'another'])
            ->assertStatus(403)
            ->assertJsonPath('data.message', 'marketplace.core.auth.password.invalid');
    }

    public function testCantUpdatePasswordWithoutPassword()
    {
        $u = User::factory()->create();

        $url = URL::signedRoute('marketplace.core.auth.password', ['type' => 'customer', 'id' => $u->id]);

        $this->postJson($url)
            ->assertStatus(422)
            ->assertJsonPath('data.message', 'marketplace.core.validation.invalid')
            ->assertJsonPath('data.errors.password.0', 'marketplace.core.validation.required');
    }

    public function testCantUpdateWithInsufficientPassword()
    {
        $u = User::factory()->create();

        $url = URL::signedRoute('marketplace.core.auth.password', ['type' => 'customer', 'id' => $u->id]);

        $this->postJson($url, ['password' => 'short'])
            ->assertStatus(422)
            ->dump()
            ->assertJsonPath('data.message', 'marketplace.core.validation.invalid')
            ->assertJsonPath('data.errors.password.0', 'marketplace.core.validation.min:6');
    }

}
