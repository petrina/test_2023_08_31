<?php

namespace App\Repositories;

use App\Models\Currency;

class CurrencyRepository
{

    /**
     * @param string $currencyCode
     * @return Currency|null
     */
    public function getByCode(string $currencyCode): ?Currency
    {
        return Currency::where('currency_code', '=', $currencyCode)->first();
    }

}
