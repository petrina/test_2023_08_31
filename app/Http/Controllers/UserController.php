<?php

namespace App\Http\Controllers;

use App\DTO\ResponseDTO\DTOResponseDTO;
use App\Http\Requests\AuthRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use \App\Exceptions\BadRequestException;
use \App\Exceptions\ServerErrorException;

class UserController extends Controller
{

    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * @param AuthRequest $request
     * @return array
     * @throws BadRequestException
     * @throws ServerErrorException
     */
    public function authentication(AuthRequest $request): array
    {
        $authUserDTO = $this->userService->authUser(
            $request->get('email'),
            $request->get('token')
        );

        return (new DTOResponseDTO($authUserDTO))->getResponse();
    }
}
