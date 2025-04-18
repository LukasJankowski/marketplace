<?php

namespace Marketplace\Core\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use Marketplace\Core\Api\TokenService;
use Marketplace\Core\Authorization\RoleService;

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
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => $this->faker->randomElement(RoleService::getRoles()),
            'api_token' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): UserFactory
    {
        return $this->state(
            function (array $attributes) {
                return [
                    'email_verified_at' => null,
                ];
            }
        );
    }

    /**
     * Set the token after getting the id from creating.
     */
    public function configure(): UserFactory
    {
        return $this->afterCreating(
            function (User $user) {
                $user->setAttribute('api_token', TokenService::generateApiToken($user->getAuthIdentifier()));
                $user->save();
            }
        );
    }
}
