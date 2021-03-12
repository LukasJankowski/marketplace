<?php

namespace Marketplace\Core\Auth\Tests;

use Marketplace\Core\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Marketplace\Core\Auth\Register\UserRegistered;
use Marketplace\Core\Auth\Verify\SendVerificationNotification;
use Marketplace\Core\Account\ValueObjects\Salutation;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    /**
     * Get the route.
     *
     * @param $type
     *
     * @return string
     */
    private function getRoute($type)
    {
        return route('marketplace.core.auth.register', ['type' => $type]);
    }

    public function testCanRegisterUser()
    {
        $this->postJson($this->getRoute('customer'), [
            'salutation' => 'marketplace.core.data.field.salutation.male',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'email@email.com',
            'phone' => '+4912345678901',
            'password' => 'password',
        ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'email' => 'email@email.com',
                    'type' => 'customer',
                    'account' => [
                        'salutation' => 'marketplace.core.data.field.salutation.male',
                        'first_name' => 'John',
                        'last_name' => 'Doe',
                        'phone' => '+4912345678901',
                    ]
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'email@email.com',
            'type' => 'customer',
        ])
            ->assertDatabaseHas('accounts', [
            'salutation' => 'marketplace.core.data.field.salutation.male',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '+4912345678901',
        ]);
    }

    public function testCanRegisterUserWithoutSalutation()
    {
        $this->postJson($this->getRoute('customer'), [
            'salutation' => null,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'email@email.com',
            'phone' => '+4912345678901',
            'password' => 'password',
        ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'account' => [
                        'salutation' => null,
                    ]
                ]
            ]);

        $this->assertDatabaseHas('accounts', [
            'salutation' => null
        ]);
    }

    public function testCantRegisterUserWithoutData()
    {
        $this->postJson($this->getRoute('customer'), [])
            ->assertStatus(422)
            ->assertJson([
                'data' => [
                    'message' => 'marketplace.core.validation.invalid',
                    'errors' => [
                        'first_name' => ['marketplace.core.validation.required'],
                        'last_name' => ['marketplace.core.validation.required'],
                        'email' => ['marketplace.core.validation.required'],
                        'password' => ['marketplace.core.validation.required'],
                    ]
                ]
            ]);
    }

    public function testCantRegisterUserWithInvalidData()
    {
        $this->postJson($this->getRoute('customer'), [
            'first_name' => 'John',
            'email' => 'invalid-email',
            'password' => 'pass',
            'salutation' => 'marketplace.core.data.field.salutation.invalid-salutation',
        ])
            ->assertStatus(422)
            ->assertJson([
                'data' => [
                    'message' => 'marketplace.core.validation.invalid',
                    'errors' => [
                        'last_name' => ['marketplace.core.validation.required'],
                        'email' => ['marketplace.core.validation.email'],
                        'password' => ['marketplace.core.validation.min:6'],
                        'salutation' => ['marketplace.core.validation.in:' . implode(',', Salutation::SALUTATIONS)],
                    ]
                ]
            ]);
    }

    public function testCantRegisterDuplicateUsers()
    {
        $this->postJson($this->getRoute('customer'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'email@email.com',
            'password' => 'password',
        ])
            ->assertStatus(201)
            ->assertJsonPath('data.email', 'email@email.com')
            ->assertJsonPath('data.type', 'customer');

        $this->postJson($this->getRoute('customer'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'email@email.com',
            'password' => 'password',
        ])
            ->assertStatus(422)
            ->assertJsonPath('data.message', 'marketplace.core.validation.invalid')
            ->assertJsonPath('data.errors.email.0', 'marketplace.core.auth.register.duplicate');
    }

    public function testCanRegisterSameUserWithDifferentTypes()
    {
        $this->postJson($this->getRoute('customer'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'email@email.com',
            'password' => 'password',
        ])
            ->assertStatus(201)
            ->assertJsonPath('data.email', 'email@email.com')
            ->assertJsonPath('data.type', 'customer');

        $this->postJson($this->getRoute('provider'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'email@email.com',
            'password' => 'password',
        ])
            ->assertStatus(201)
            ->assertJsonPath('data.email', 'email@email.com')
            ->assertJsonPath('data.type', 'provider');

        $this->assertDatabaseHas('users', [
            'email' => 'email@email.com',
            'type' => 'customer'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'email@email.com',
            'type' => 'provider'
        ]);
    }

    public function testEventIsEmittedOnRegister()
    {
        Event::fake();

        $this->postJson($this->getRoute('customer'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'email@email.com',
            'password' => 'password',
        ])
            ->assertStatus(201)
            ->assertJsonPath('data.email', 'email@email.com')
            ->assertJsonPath('data.type', 'customer');

        Event::assertDispatched(
            UserRegistered::class,
            fn(UserRegistered $e) => $e->getUser()->getAttribute('email') === 'email@email.com'
        );
    }

    public function testNotificationSentOnRegister()
    {
        $this->postJson($this->getRoute('customer'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'email@email.com',
            'password' => 'password',
        ])
            ->assertStatus(201)
            ->assertJsonPath('data.email', 'email@email.com')
            ->assertJsonPath('data.type', 'customer');

        Notification::assertSentTo(
            User::query()->first(),
            SendVerificationNotification::class
        );
    }
}
