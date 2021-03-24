<?php

namespace Marketplace\Core\User\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Marketplace\Core\Auth\Login\UserLoggedIn;
use Marketplace\Core\Role\RoleService;
use Marketplace\Foundation\Tests\TestsHelperTrait;
use Tests\TestCase;

class ListTest extends TestCase
{
    use RefreshDatabase;
    use TestsHelperTrait;

    public function testCantGetAllUsersWhenNotAuthenticated()
    {
        $this->getJson(route('marketplace.core.user.list'))
            ->assertStatus(401)
            ->assertJsonPath('data.message', 'marketplace.core.authorization.unauthorized');
    }

    public function testCantGetAllUsersWhenNotAdmin()
    {
        $u = $this->getUser();

        $this->actingAs($u)
            ->getJson(route('marketplace.core.user.list'))
            ->assertStatus(401)
            ->assertJsonPath('data.message', 'marketplace.core.authorization.unauthorized');
    }

    public function testCanGetAllUsers()
    {
        $u = $this->getUser(['role' => 'admin']);

        $this->actingAs($u)
            ->getJson(route('marketplace.core.user.list'))
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }
}
