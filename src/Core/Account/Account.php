<?php

namespace Marketplace\Core\Account;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Marketplace\Core\Account\Dtos\AccountDto;
use Marketplace\Core\User\User;
use Marketplace\Foundation\DataTransferObjects\DataTransferObjectInterface;
use Marketplace\Foundation\DataTransferObjects\HasDtoFactory;
use Marketplace\Foundation\Models\ModelsHelperTrait;

class Account extends Model implements HasDtoFactory
{
    use HasFactory;
    use ModelsHelperTrait;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'salutation',
        'first_name',
        'last_name',
        'phone',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        //'salutation' => BaseCast::class . ':' . Salutation::class,
        //'first_name' => BaseCast::class . ':' . Name::class,
        //'last_name' => BaseCast::class . ':' . Name::class,
        //'phone' => BaseCast::class . ':' . Phone::class,
    ];

    /**
     * @inheritdoc
     */
    public function asDto(): DataTransferObjectInterface
    {
        return new AccountDto(
            userId: $this->getAttribute('user_id'),
            salutation: $this->getAttribute('salutation'),
            firstName: $this->getAttribute('first_name'),
            lastName: $this->getAttribute('last_name'),
            phone: $this->getAttribute('phone'),
        );
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return AccountFactory::new();
    }

    /**
     * Account belongs to user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
