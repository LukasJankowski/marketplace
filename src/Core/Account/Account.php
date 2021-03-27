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
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'salutation',
        'first_name',
        'last_name',
        'phone',
    ];

    /**
     * @inheritdoc
     */
    public function asDto(): DataTransferObjectInterface
    {
        return AccountDto::make(...$this->getAttributesByFillableKeys());
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return AccountFactory::new();
    }

    /**
     * Account belongs to user.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
