<?php

namespace Marketplace\Core\User\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Marketplace\Foundation\Tests\TestsHelperTrait;
use Tests\TestCase;

class ReadTest extends TestCase
{
    use RefreshDatabase;
    use TestsHelperTrait;

    public function testCantGetUserWhenNotAuthenticated()
    {
        $this->getJson(route('marketplace.core.user.read', [1]))
            ->assertStatus(401)
            ->assertJsonPath('data.message', 'marketplace.core.authentication.unauthenticated');
    }

    public function testCantGetUserWhenNotAdminOrSelf()
    {
        $u = $this->getUser(['role' => 'customer']);

        $this->actingAs($u)
            ->getJson(route('marketplace.core.user.read', ['id' => 999]))
            ->assertStatus(403)
            ->assertJsonPath('data.message', 'marketplace.core.authorization.unauthorized');
    }

    public function testCanGetUserWhenAdmin()
    {
        $a = $this->getUser(['role' => 'admin']);
        $u = $this->getUser(['role' => 'customer']);

        $this->actingAs($a)
            ->getJson(route('marketplace.core.user.read', ['id' => $u->id]))
            ->assertStatus(200)
            ->assertJsonPath('data.id', $u->id)
            ->assertJsonPath('data.email', $u->email)
            ->assertJsonPath('data.role', $u->role);
    }

    public function testCanGetUserWhenSelf()
    {
        $u = $this->getUser(['role' => 'customer']);

        $this->actingAs($u)
            ->getJson(route('marketplace.core.user.read', ['id' => $u->id]))
            ->assertStatus(200)
            ->assertJsonPath('data.id', $u->id)
            ->assertJsonPath('data.email', $u->email)
            ->assertJsonPath('data.role', $u->role);
    }
}
