<?php

namespace Marketplace\Core\Auth\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

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
        // WIP
        $this->postJson($this->getRoute('customer'), [
            'salutation' => 'marketplace.core.data.field.salutation.male',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'email@email.com',
            'phone' => '+4912345678901',
            'password' => 'password',
        ])
            ->assertStatus(201);
    }

    public function testCanRegisterUserWithoutSalutation()
    {
        // WIP
        $this->postJson($this->getRoute('customer'), [
            'salutation' => null,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'email@email.com',
            'phone' => '+4912345678901',
            'password' => 'password',
        ])
            ->assertStatus(201);

        $this->postJson($this->getRoute('customer'), [
            // no salutation
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'email@email.com',
            'phone' => '+4912345678901',
            'password' => 'password',
        ])
            ->assertStatus(201);
    }
}
