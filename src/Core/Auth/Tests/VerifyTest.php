<?php

namespace Marketplace\Core\Auth\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Marketplace\Core\User\User;
use Tests\TestCase;

class VerifyTest extends TestCase
{
    use RefreshDatabase;

    public function testCanVerifyUser()
    {
        $u = User::factory()->unverified()->create();

        $url = URL::signedRoute('marketplace.core.auth.verify', ['id' => $u->id]);

        $this->assertDatabaseHas(
            'users',
            [
                'id' => $u->id,
                'email_verified_at' => null,
            ]
        );

        $this->getJson($url)
            ->assertStatus(200)
            ->assertJsonPath('data.email', $u->email)
            ->assertJsonPath('data.verified', true);
    }

    public function testCantVerifyWithInvalidUrl()
    {
        $u = User::factory()->unverified()->create();

        $url = URL::signedRoute('marketplace.core.auth.verify', ['id' => $u->id]);
        $url = substr($url, 0, -6); // broken signature

        $this->getJson($url)
            ->assertStatus(403)
            ->assertJsonPath('data.message', 'marketplace.core.authorization.unauthorized');
    }

    public function testCantVerifyWithInvalidId()
    {
        $url = URL::signedRoute('marketplace.core.auth.verify', ['id' => 1]);

        $this->getJson($url)
            ->assertStatus(403)
            ->assertJsonPath('data.message', 'marketplace.core.auth.verification.invalid');
    }
}
