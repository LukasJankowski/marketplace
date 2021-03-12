<?php

namespace Marketplace\Core\Auth\Tests;

use Marketplace\Core\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Marketplace\Core\Auth\Reset\SendResetNotification;
use Tests\TestCase;

class ResetTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    public function testCanSendPasswordReset()
    {
        $u = User::factory()->create(['type' => 'customer']);

        $this->postJson(route('marketplace.core.auth.reset', ['type' => 'customer']), [
            'email' => $u->email
        ])
            ->assertStatus(200)
            ->assertJsonPath('data.success', true)
            ->assertJsonPath('data.email', $u->email);

        Notification::assertSentTo($u, SendResetNotification::class);
    }

    public function testCantSendPasswordResetToInvalidEmail()
    {
        $this->postJson(route('marketplace.core.auth.reset', ['type' => 'customer']), [
            'email' => 'invalid-email'
        ])
            ->assertStatus(422)
            ->assertJsonPath('data.message', 'marketplace.core.validation.invalid')
            ->assertJsonPath('data.errors.email.0', 'marketplace.core.validation.email');
    }

    public function testCantSendPasswordResetToUnknownUser()
    {
        $this->postJson(route('marketplace.core.auth.reset', ['type' => 'customer']), [
            'email' => 'non-existing@email.com',
        ])
            ->assertStatus(422)
            ->assertJsonPath('data.message', 'marketplace.core.validation.invalid')
            ->assertJsonPath('data.errors.email.0', 'marketplace.core.auth.reset.invalid');
    }
}
