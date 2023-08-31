<?php

namespace App\Repositories;

use App\DTO\CreateSellDTO;
use App\Models\Sell;
use Illuminate\Support\Collection;

class SellRepository
{

    /**
     * @param CreateSellDTO $createSellDTO
     * @return bool
     */
    public function create(CreateSellDTO $createSellDTO): bool
    {
        return Sell::insert($createSellDTO->getData());
    }

    /**
     * @return Collection
     */
    public function getOpenedSells(): Collection
    {
        return Sell::where([
            ['buyer_id', '=', null],
        ])->get();
    }

    public function getOpendById(int $sellId): ?Sell {
        return Sell::where([
            ['buyer_id', '=', null],
            ['id', '=', $sellId],
        ])->first();
    }

    public function getClosed() : Collection {
        return Sell::where([
            ['buyer_id', '!=', null]
        ])
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}
