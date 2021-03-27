<?php

namespace Marketplace\Core\User\Tests;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Marketplace\Core\Authentication\Notifications\SendResetNotification;
use Marketplace\Core\Authentication\Notifications\SendVerificationNotification;
use Marketplace\Core\User\Dtos\CredentialsDto;
use Marketplace\Core\User\User;
use Marketplace\Core\User\UserService;
use Marketplace\Core\User\ValueObjects\Password;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGetAllUsers()
    {
        $users = User::factory()->count(5)->create();

        $service = new UserService();
        $this->assertEquals($users->toArray(), $service->getAllUsers()->toArray());
    }

    public function testWillReturnEmptyIfNoUsersExist()
    {
        $service = new UserService();
        $this->assertEquals([], $service->getAllUsers()->toArray());
    }

    public function testCanGetUserByCredentials()
    {
        $user = User::factory()->create();

        $creds = CredentialsDto::make(
            $user->email,
            'password',
            $user->role
        );
        $service = new UserService();
        $this->assertEquals($user->fresh(), $service->getUserByCredentials($creds));
    }

    public function testCanAlwaysGetExistingUsersByCredentials()
    {
        // A weird bug did occur a while back. The service function didn't always
        // provide the model but returned null for unknown reasons.
        for ($i = 0; $i < 25; $i++) {
            $user = User::factory()->create();

            $creds = CredentialsDto::make(
                $user->email,
                'password',
                $user->role
            );

            $user = User::query()->where('email', $user->email)->first();

            $service = new UserService();
            $this->assertEquals($user, $service->getUserByCredentials($creds));
        }
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

        $this->assertDatabaseHas(
            'users',
            [
                'email' => 'email@email.com',
                'role' => 'customer',
            ]
        );
    }

    public function testCanMarkUserAsVerified()
    {
        $user = User::factory()->unverified()->create();

        $service = new UserService();
        $service->markUserVerified($user->id);

        $user->refresh();

        $this->assertDatabaseHas(
            'users',
            [
                'email' => $user->email,
                'role' => $user->role,
                'email_verified_at' => $user->email_verified_at,
            ]
        );
    }

    public function testCanVerifyAlreadyVerifiedUsers()
    {
        $user = User::factory()->create();

        $service = new UserService();
        $service->markUserVerified($user->id);

        $user->refresh();

        $this->assertDatabaseHas(
            'users',
            [
                'email' => $user->email,
                'role' => $user->role,
                'email_verified_at' => $user->email_verified_at,
            ]
        );
    }

    public function testThrowsExceptionOnInvalidUserId()
    {
        $this->expectException(ModelNotFoundException::class);

        $service = new UserService();
        $service->getUserById(999);
    }

    public function testCanGetUserById()
    {
        $u = User::factory()->create();

        $service = new UserService();
        $this->assertEquals(
            User::query()->find($u->id),
            $service->getUserById($u->id)
        );
    }

    public function testCanSendVerificationToUser()
    {
        Notification::fake();

        $u = User::factory()->create();

        $service = new UserService();
        $service->sendVerificationEmailToUser($u);

        Notification::assertSentTo($u, SendVerificationNotification::class);
    }

    public function testCanUpdatePasswordOfUser()
    {
        $u = User::factory()->create();

        $service = new UserService();
        $service->updatePasswordOfUser($u->id, Password::make('another'));

        $u->refresh();

        $this->assertTrue(
            Hash::check('another', $u->password)
        );
    }

    public function testCanSendPasswordResetToUser()
    {
        Notification::fake();

        $u = User::factory()->create();

        $service = new UserService();
        $service->sendPasswordResetEmailToUser($u);

        Notification::assertSentTo($u, SendResetNotification::class);
    }
}
