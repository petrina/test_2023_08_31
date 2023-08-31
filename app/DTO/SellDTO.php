<?php

namespace App\DTO;

class SellDTO extends BaseDTO
{
    private int $sellId;
    private string $currencySell;
    private string $currency;
    private float $count;
    private float $price;

    public function __construct(int $sellId, string $currencySell, float $count, string $currency, float $price) {
        $this->sellId = $sellId;
        $this->currencySell = $currencySell;
        $this->count = $count;
        $this->currency = $currency;
        $this->price = $price;
    }

    public function getData(): array
    {
        return [
            'id' => $this->sellId,
            'sell' => [
                'currency' => $this->currencySell,
                'count' => $this->count,
            ],
            'buy' => [
                'currency' => $this->currency,
                'count' => $this->price,
            ]
        ];
    }
}
