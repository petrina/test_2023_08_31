<?php

namespace App\DTO;

class WalletDTO extends BaseDTO
{

    private int $amount;
    private string $currency;
    private int $walletId;

    public function __construct(int $walletId, string $currency, int $amount) {
        $this->walletId = $walletId;
        $this->currency = $currency;
        $this->amount = $amount;
    }

    public function getData(): array
    {
        return [
            'walletId' => $this->walletId,
            'currency' => $this->currency,
            'amount' => $this->amount,
        ];
    }
}
