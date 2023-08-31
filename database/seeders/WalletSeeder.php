<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $currencies = Currency::all();

        foreach ($users as $user) {
            foreach ($currencies as $currency) {
                (new Wallet())
                    ->setUser($user)
                    ->setCurrency($currency)
                    ->setAmount(rand(1,6) * (($currency->getCurrencyCode() === 'UAH') ? 1000 : 100))
                    ->save();
            }
        }
    }
}
