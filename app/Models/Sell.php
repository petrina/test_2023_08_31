<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property Wallet $seller_wallet_id
 * @property float $count
 * @property float $price
 * @property Currency $currency
 * @property float $fee
 * @property User $buyer
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Sell extends Model
{
    use HasFactory;

    public function getId(): int
    {
        return $this->id;
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'seller_wallet_id');
    }

    public function setSellerWalletId(Wallet $seller_wallet): void
    {
        $this->seller_wallet_id = $seller_wallet->getId();
    }

    public function getCount(): float
    {
        return $this->count;
    }

    public function setCount(float $count): Sell
    {
        $this->count = $count;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): Sell
    {
        $this->price = $price;
        return $this;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function setCurrency(Currency $currency): Sell
    {
        $this->currency_id = $currency->getId();
        return $this;
    }

    public function getFee(): float
    {
        return $this->fee;
    }

    public function setFee(float $fee): Sell
    {
        $this->fee = $fee;
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

    public function buyer() :BelongsTo {
        return $this->belongsTo(User::class, 'buyer_id');
    }
//    public function getBuyerId(): User
//    {
//        return $this->buyer_id;
//    }

    public function setBuyer(User $buyer): Sell
    {
        $this->buyer_id = $buyer->getId();
        return $this;
    }
}
