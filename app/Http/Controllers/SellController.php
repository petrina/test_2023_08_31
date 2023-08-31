<?php

namespace App\Http\Controllers;

use App\DTO\ResponseDTO\CollectionResponseDTO;
use App\Http\Requests\CreateSellRequest;
use App\Services\SellService;
use \App\Exceptions\BadRequestException;
use \App\Exceptions\ServerErrorException;
use \App\Exceptions\NotFoundException;
use \Illuminate\Contracts\Foundation\Application;
use \Illuminate\Contracts\Routing\ResponseFactory;
use \Illuminate\Foundation\Application as FoundationApp;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;

class SellController extends Controller
{
    private SellService $sellService;

    public function __construct(
        SellService $sellService
    )
    {
        $this->sellService = $sellService;
    }

    /**
     * @param int $walletId
     * @param CreateSellRequest $request
     * @return Application|ResponseFactory|FoundationApp|Response
     * @throws BadRequestException
     * @throws ServerErrorException
     */
    public function create(int $walletId, CreateSellRequest $request): FoundationApp|Response|Application|ResponseFactory
    {
        $this->sellService->createSell(
            $request->header('auth-token'),
            $walletId,
            $request->get('count'),
            $request->get('price'),
            $request->get('currency')
        );

        return response('', 204);
    }

    /**
     * @return array
     */
    public function store(): array
    {
        $collectionDTO = $this->sellService->getOpenedSells();
        return (new CollectionResponseDTO($collectionDTO))->getResponse();
    }

    /**
     * @param int $sellId
     * @param Request $request
     * @return Application|ResponseFactory|FoundationApp|Response
     * @throws BadRequestException
     * @throws ServerErrorException
     * @throws NotFoundException
     */
    public function approve(int $sellId, Request $request): FoundationApp|Response|Application|ResponseFactory
    {
        $this->sellService->sellApprove($request->header('auth-token'), $sellId);
        return \response('', 204);
    }

    /**
     * @return array
     */
    public function report(): array
    {
        $collectionDTO = $this->sellService->report();
        return (new CollectionResponseDTO($collectionDTO))->getResponse();
    }
}
