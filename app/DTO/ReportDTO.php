<?php

namespace App\DTO;

use Carbon\Carbon;

class ReportDTO extends BaseDTO
{
    private string $userName;
    private float $count;
    private string $currencyCode;
    private float $fee;
    private string $feeCurrencyCode;
    private Carbon $dateTime;

    public function __construct(
        string $userName,
        float $count,
        string $currencyCode,
        float $fee,
        string $feeCurrencyCode,
        Carbon $dateTime
    )
    {
        $this->userName = $userName;
        $this->count = $count;
        $this->currencyCode = $currencyCode;
        $this->fee = $fee;
        $this->feeCurrencyCode = $feeCurrencyCode;
        $this->dateTime = $dateTime;
    }

    public function getData(): array
    {
        return [
            'User '.$this->userName.' bought '. $this->count.' '.$this->currencyCode.' and fee '.$this->fee.' '.$this->feeCurrencyCode.' at '.$this->dateTime
        ];
    }
}
