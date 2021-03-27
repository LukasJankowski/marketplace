<?php

namespace Marketplace\Core\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Marketplace\Core\Account\Account;
use Marketplace\Core\User\Dtos\UserDto;
use Marketplace\Foundation\DataTransferObjects\DataTransferObjectInterface;
use Marketplace\Foundation\DataTransferObjects\HasDtoFactory;
use Marketplace\Foundation\Models\ModelsHelperTrait;

class User extends Authenticatable implements HasDtoFactory
{
    use HasFactory;
    use Notifiable;
    use ModelsHelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'email',
        'password',
        'role',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //'email' => BaseCast::class . ':' . Email::class,
        //'password' => BaseCast::class . ':' . Password::class,
        //'role' => BaseCast::class . ':' . Role::class,
        'email_verified_at' => 'datetime',
    ];

    /**
     * @inheritdoc
     */
    public function asDto(): DataTransferObjectInterface
    {
        return new UserDto(
            userId: $this->getAttribute('user_id'),
            email: $this->getAttribute('email'),
            password: $this->getAttribute('password'),
            role: $this->getAttribute('role'),
            apiToken: $this->getAttribute('api_token'),
        );
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    /**
     * User has account.
     */
    public function account(): HasOne
    {
        return $this->hasOne(Account::class);
    }
}
