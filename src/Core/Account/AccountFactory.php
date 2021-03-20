<?php

namespace Marketplace\Core\Account;

use Illuminate\Database\Eloquent\Factories\Factory;
use Marketplace\Core\Account\ValueObjects\Salutation;
use Marketplace\Core\User\User;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'salutation' => $this->faker->randomElement(Salutation::SALUTATIONS + [null]),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->randomElement([$this->faker->phoneNumber, null]),
        ];
    }
}
