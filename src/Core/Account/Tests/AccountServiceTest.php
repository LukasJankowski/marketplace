<?php

namespace Marketplace\Core\Account\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Marketplace\Core\Account\AccountService;
use Marketplace\Core\Account\Dtos\AccountDto;
use Marketplace\Core\User\User;
use Tests\TestCase;

class AccountServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateNewAccount()
    {
        $user = User::factory()->create();

        $account = new AccountDto(
            userId: null,
            salutation: null,
            firstName: 'John',
            lastName: 'Doe',
            phone: null
        );

        $service = new AccountService();
        $service->create($account, $user);

        $this->assertDatabaseHas(
            'accounts',
            [
                'user_id' => $user->id,
                'salutation' => null,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'phone' => null,
            ]
        );
    }

    public function testCanCreateAccountWithId()
    {
        $user = User::factory()->create();

        $account = new AccountDto(
            userId: null,
            salutation: null,
            firstName: 'John',
            lastName: 'Doe',
            phone: null
        );

        $service = new AccountService();
        $service->create($account, $user->id);

        $this->assertDatabaseHas(
            'accounts',
            [
                'user_id' => $user->id,
                'salutation' => null,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'phone' => null,
            ]
        );
    }
}
