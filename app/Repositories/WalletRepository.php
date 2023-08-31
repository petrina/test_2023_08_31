<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Collection;

class WalletRepository
{

    public function getAllByUser(User $user): Collection
    {
        return Wallet::where('user_id', '=', $user->id)->get();
    }

    public function getWallet(int $walletId): ?Wallet
    {
        return Wallet::where('id', '=', $walletId)->first();
    }

}
