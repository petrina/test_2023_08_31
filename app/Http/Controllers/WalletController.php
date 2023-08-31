<?php

namespace App\Http\Controllers;

use App\DTO\ResponseDTO\CollectionResponseDTO;
use App\DTO\ResponseDTO\DTOResponseDTO;
use App\Repositories\WalletRepository;
use App\Services\WalletService;
use Illuminate\Http\Request;
use \App\Exceptions\BadRequestException;

class WalletController extends Controller
{

    private WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * @param Request $request
     * @return array
     * @throws BadRequestException
     */
    public function store(Request $request): array
    {
        $walletsCollection = $this->walletService->getAllWalletsWithCurrency($request->header('auth-token'));

        return (new CollectionResponseDTO($walletsCollection))->getResponse();
    }
}
