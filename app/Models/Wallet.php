<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property User $user
 * @property Currency $currency
 * @property int $amount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Wallet extends Model
{
    use HasFactory;

    public function getId(): int
    {
        return $this->id;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

//    public function getUser(): BelongsTo
//    {
//        return $this->belongsTo(User::class);
//    }

    public function setUser(User $user): Wallet
    {
        $this->user_id = $user->id;
        return $this;
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
//    public function getCurrency(): BelongsTo
//    {
//        return $this->belongsTo(Currency::class);
//    }

    public function setCurrency(Currency $currency): Wallet
    {
        $this->currency_id = $currency->id;
        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): Wallet
    {
        $this->amount = $amount;
        return $this;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }
}
