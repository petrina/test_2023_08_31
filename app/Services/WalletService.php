<?php

namespace App\Services;

use App\DTO\CollectionDTO;
use App\DTO\WalletDTO;
use App\Exceptions\BadRequestException;
use App\Models\User;
use App\Models\Wallet;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use \Illuminate\Database\Eloquent\Collection;

class WalletService
{

    private WalletRepository $walletRepo;
    private UserRepository $userRepo;

    public function __construct(
        WalletRepository $walletRepo,
        UserRepository   $userRepo
    )
    {
        $this->walletRepo = $walletRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * @param User $authToken
     * @return Collection
     * @throws BadRequestException
     */
    public function getAllWallets(User $user): Collection
    {
        return $this->walletRepo->getAllByUser($user);
    }

    /**
     * @param string|null $authToken
     * @return CollectionDTO
     * @throws BadRequestException
     */
    public function getAllWalletsWithCurrency(?string $authToken): CollectionDTO
    {

        $user = $this->userRepo->getUserByAuthToken($authToken);
        if ($user === null) {
            throw new BadRequestException('Access denied');
        }

        /** @var Wallet[] $wallets */
        $wallets = $user->wallets;
        $collection = new CollectionDTO();
        foreach ($wallets as $wallet) {
            $collection->add(new WalletDTO(
                $wallet->getId(),
                $wallet->currency->getCurrencyCode(),
                $wallet->getAmount()
            ));
        }

        return $collection;
    }
}
