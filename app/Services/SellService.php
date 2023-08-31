<?php

namespace App\Services;

use App\DTO\CollectionDTO;
use App\DTO\CreateSellDTO;
use App\DTO\ReportDTO;
use App\DTO\SellDTO;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Exceptions\ServerErrorException;
use App\Models\Currency;
use App\Models\Sell;
use App\Models\Wallet;
use App\Repositories\CurrencyRepository;
use App\Repositories\SellRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SellService
{

    private UserRepository $userRepo;
    private WalletRepository $walletRepo;
    private SellRepository $sellRepo;
    private CurrencyRepository $currencyRepo;

    public function __construct(
        UserRepository     $userRepo,
        WalletRepository   $walletRepo,
        SellRepository     $sellRepo,
        CurrencyRepository $currencyRepo
    )
    {
        $this->userRepo = $userRepo;
        $this->walletRepo = $walletRepo;
        $this->sellRepo = $sellRepo;
        $this->currencyRepo = $currencyRepo;
    }

    /**
     * @param string $authToken
     * @param int $walletId
     * @param int $count
     * @param int $price
     * @param string $currencyCode
     * @return void
     * @throws BadRequestException
     * @throws ServerErrorException
     * @throws NotFoundException
     */
    public function createSell(string $authToken, int $walletId, int $count, int $price, string $currencyCode): void
    {

        $user = $this->userRepo->getUserByAuthToken($authToken);
        if ($user === null) {
            throw new BadRequestException('Access denied');
        }

        $wallet = $this->walletRepo->getWallet($walletId);
        if ($wallet->user->getId() !== $user->getId()) {
            throw new BadRequestException('Access denied');
        }

        if ($wallet->getAmount() < $count || $count < 0) {
            throw new BadRequestException('Incorrect money');
        }

        if ($price < 0) {
            throw new BadRequestException('Incorrect money');
        }

        $currency = $this->currencyRepo->getByCode($currencyCode);
        if ($currency === null) {
            throw new NotFoundException('Incorrect currency');
        }

        $createDTO = new CreateSellDTO($wallet, $count, $price, $currency, $price * (env('FEE_PERCENT', 2) / 100));
        if ($this->sellRepo->create($createDTO) !== true) {
            throw new ServerErrorException('Sell was not created');
        }
    }

    /**
     * @return CollectionDTO
     */
    public function getOpenedSells(): CollectionDTO
    {
        /** @var Sell[] $openedSells */
        $openedSells = $this->sellRepo->getOpenedSells();

        $collectionDTO = new CollectionDTO();
        foreach ($openedSells as $openedSell) {
            $sellCurrencyCode = $openedSell->wallet->currency->getCurrencyCode();
            $currencyCode = $openedSell->currency->getCurrencyCode();

            $sellDTO = new SellDTO(
                $openedSell->getId(),
                $sellCurrencyCode,
                $openedSell->getCount(),
                $currencyCode,
                $openedSell->getPrice() + $openedSell->getFee()
            );
            $collectionDTO->add($sellDTO);
        }

        return $collectionDTO;
    }

    /**
     * @param string $authToken
     * @param int $sellId
     * @return void
     * @throws BadRequestException
     * @throws ServerErrorException
     * @throws NotFoundException
     */
    public function sellApprove(string $authToken, int $sellId): void
    {
        $user = $this->userRepo->getUserByAuthToken($authToken);
        if ($user === null) {
            throw new BadRequestException('Access denied');
        }

        $sell = $this->sellRepo->getOpendById($sellId);
        if ($sell === null) {
            throw new NotFoundException('Sell unknown');
        }

        /** @var Wallet $sellerWalletMinus */
        $sellerWalletMinus = $sell->wallet;
        $sellerWalletPlus = $this->searchWalletWithCurrency($sell->wallet->user->wallets, $sell->currency->getId());
        $buyerWalletMinus = $this->searchWalletWithCurrency($user->wallets, $sell->currency->getId());
        $buyerWalletPlus = $this->searchWalletWithCurrency($user->wallets, $sell->wallet->currency->getId());

        if ($sellerWalletPlus === null ||
            $sellerWalletMinus === null ||
            $buyerWalletPlus === null ||
            $buyerWalletMinus === null) {
            throw new NotFoundException('Wallet not found');
        }

        if ($sellerWalletMinus->getAmount() < $sell->getCount()) {
            throw new NotFoundException('Seller\'s money not found');
        }

        if ($buyerWalletMinus->getAmount() < $sell->getPrice() + $sell->getFee()) {
            throw new NotFoundException('Buyer\'s money not found');
        }

        DB::beginTransaction();
        $buyerWalletMinus->setAmount($buyerWalletMinus->getAmount() - ($sell->getPrice() + $sell->getFee()))->save();
        $sellerWalletPlus->setAmount($sellerWalletPlus->getAmount() + $sell->getPrice())->save();
        $sellerWalletMinus->setAmount($sellerWalletMinus->getAmount() - $sell->getCount())->save();
        $buyerWalletPlus->setAmount($buyerWalletPlus->getAmount() + $sell->getCount())->save();
        $sell->setBuyer($user)->save();
        DB::commit();
    }

    /**
     * @param Collection $wallets
     * @param Sell $sell
     * @return Wallet|null
     * @throws ServerErrorException
     */
    private function searchWalletWithCurrency(Collection $wallets, int $currencyId): ?Wallet
    {
        $walletCurrency = null;
        foreach ($wallets as $wallet) {
            if ($wallet->currency->getId() === $currencyId) {
                $walletCurrency = $wallet;
                break;
            }
        }

        return $walletCurrency;
    }

    /**
     * @return CollectionDTO
     */
    public function report(): CollectionDTO
    {
        /** @var Sell[] $closedSells */
        $closedSells = $this->sellRepo->getClosed();

        $collectionDTO = new CollectionDTO();

        foreach ($closedSells as $closedSell) {
            $reportDTO = new ReportDTO(
                $closedSell->buyer->getName(),
                $closedSell->getCount(),
                $closedSell->wallet->currency->getCurrencyCode(),
                $closedSell->getFee(),
                $closedSell->currency->getCurrencyCode(),
                $closedSell->getUpdatedAt()
            );
            $collectionDTO->add($reportDTO);
        }

        return $collectionDTO;
    }
}
