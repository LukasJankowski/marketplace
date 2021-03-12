<?php

namespace Marketplace\Core\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Marketplace\Core\Api\TokenService;
use Marketplace\Core\Type\TypeService;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'type' => $this->faker->randomElement(TypeService::getClasses()),
            'api_token' => null,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Set the token after getting the id from creating.
     *
     * @return UserFactory
     */
    public function configure(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $user->setAttribute('api_token', TokenService::generateApiToken($user->getAuthIdentifier()));
            $user->save();
        });
    }
}
