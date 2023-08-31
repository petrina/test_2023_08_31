<?php

namespace App\DTO;

use App\Models\Currency;
use App\Models\Wallet;
use Carbon\Carbon;

class CreateSellDTO extends BaseDTO
{
    private int $walletId;
    private float $count;
    private float $price;
    private int $currencyId;
    private float $fee;


    public function __construct(
        Wallet   $wallet,
        float    $count,
        float    $price,
        Currency $currency,
        float    $fee
    )
    {
        $this->walletId = $wallet->getId();
        $this->count = $count;
        $this->price = $price;
        $this->currencyId = $currency->getId();
        $this->fee = $fee;
    }

    public function getData(): array
    {
        return [
            'seller_wallet_id' => $this->walletId,
            'count' => $this->count,
            'price' => $this->price,
            'currency_id' => $this->currencyId,
            'fee' => $this->fee,
            'created_at' => Carbon::now(),
         ];
    }
}
