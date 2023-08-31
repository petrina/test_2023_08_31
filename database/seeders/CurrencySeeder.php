<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newCurrency = new Currency();
        $newCurrency->currency = 'Hryvnya';
        $newCurrency->currency_code = 'UAH';
        $newCurrency->save();

        $newCurrency = new Currency();
        $newCurrency->currency = 'Dollar';
        $newCurrency->currency_code = 'USD';
        $newCurrency->save();

        $newCurrency = new Currency();
        $newCurrency->currency = 'Euro';
        $newCurrency->currency_code = 'EUR';
        $newCurrency->save();
    }
}
