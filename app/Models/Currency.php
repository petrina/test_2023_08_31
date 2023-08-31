<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $currency
 * @property string $currency_code
 */
class Currency extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCurrencyCode(): string
    {
        return $this->currency_code;
    }

}
