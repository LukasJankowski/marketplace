<?php

namespace Marketplace\Core\Authentication\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Marketplace\Core\Authentication\Reset\SendResetNotification;
use Marketplace\Foundation\Tests\TestsHelperTrait;
use Tests\TestCase;

class ResetTest extends TestCase
{
    use RefreshDatabase;
    use TestsHelperTrait;

    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    public function testCanSendPasswordReset()
    {
        $u = $this->getUser();

        $this->postJson(
            route('marketplace.core.authentication.reset', ['role' => 'customer']),
            [
                'email' => $u->email,
            ]
        )
            ->assertStatus(200)
            ->assertJsonPath('data.success', true)
            ->assertJsonPath('data.email', $u->email);

        Notification::assertSentTo($u, SendResetNotification::class);
    }

    public function testCantSendPasswordResetToInvalidEmail()
    {
        $this->postJson(
            route('marketplace.core.authentication.reset', ['role' => 'customer']),
            [
                'email' => 'invalid-email',
            ]
        )
            ->assertStatus(422)
            ->assertJsonPath('data.message', 'marketplace.core.validation.invalid')
            ->assertJsonPath('data.errors.email.0', 'marketplace.core.validation.email');
    }

    public function testCantSendPasswordResetToUnknownUser()
    {
        $this->postJson(
            route('marketplace.core.authentication.reset', ['role' => 'customer']),
            [
                'email' => 'non-existing@email.com',
            ]
        )
            ->assertStatus(422)
            ->assertJsonPath('data.message', 'marketplace.core.validation.invalid')
            ->assertJsonPath('data.errors.email.0', 'marketplace.core.authentication.reset.invalid');
    }
}
