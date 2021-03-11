<?php

namespace Marketplace\Foundation\Tests;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Marketplace\Core\Data\User\Dtos\CredentialsDto;
use Marketplace\Foundation\Services\User\UserService;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGetUserByCredentials()
    {
        $user = User::factory()->create();

        $creds = CredentialsDto::make(
            $user->email,
            $user->password,
            $user->type
        );

        $user = User::query()->first();

        $service = new UserService();
        $this->assertEquals($user, $service->getUserByCredentials($creds));
    }

    public function testReturnsNullIfNoMatchingUserExists()
    {
        $creds = CredentialsDto::make(
            'email@email.com',
            'password',
            'customer'
        );

        $service = new UserService();
        $this->assertNull($service->getUserByCredentials($creds));
    }

    public function testCanCreateNewUser()
    {
        $creds = CredentialsDto::make(
            'email@email.com',
            'password',
            'customer'
        );

        $service = new UserService();
        $service->create($creds);

        $this->assertDatabaseHas('users', [
            'email' => 'email@email.com',
            'password' => 'password',
            'type' => 'customer',
        ]);
    }

    public function testCanMarkUserAsVerified()
    {
        $user = User::factory()->unverified()->create();

        $service = new UserService();
        $user = $service->markUserVerified($user->id);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'type' => $user->type,
            'email_verified_at' => $user->email_verified_at
        ]);
    }

    public function testCanVerifyAlreadyVerifiedUsers()
    {
        $user = User::factory()->create();

        $service = new UserService();
        $user = $service->markUserVerified($user->id);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'type' => $user->type,
            'email_verified_at' => $user->email_verified_at
        ]);
    }

    public function testThrowsExceptionOnInvalidUserId()
    {
        $this->expectException(ModelNotFoundException::class);

        $service = new UserService();
        $user = $service->markUserVerified(999);
    }

}
