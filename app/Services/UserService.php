<?php

namespace App\Services;

use App\DTO\AuthUserDTO;
use App\Exceptions\BadRequestException;
use App\Exceptions\ServerErrorException;
use App\Repositories\UserRepository;
use Carbon\Carbon;

class UserService
{
    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @param string $userEmail
     * @param string $personalToken
     * @return AuthUserDTO
     * @throws BadRequestException
     * @throws ServerErrorException
     */
    public function authUser(string $userEmail, string $personalToken): AuthUserDTO
    {
        $user = $this->userRepo->getAuthTokenByEmailAndPersonalToken($userEmail, $personalToken);

        if ($user === null) {
            throw new BadRequestException('User not found');
        }

        $newToken = base64_encode($personalToken . Carbon::now());
        $addMin = env('TIME_LIVE_AUTH_TOKEN_MINUTES', 10);
        $tokenLifeTo = Carbon::now()->addMinutes($addMin);

        if ($this->userRepo->updateAuthToken($user, $newToken, $tokenLifeTo)) {
            return new AuthUserDTO($newToken, Carbon::now(), $tokenLifeTo);
        } else {
            throw new ServerErrorException('Can\'t update token');
        }

    }

    /**
     * @param array $headers
     * @return void
     * @throws BadRequestException
     */
    public function checkAuthToken(?string $authToken): void
    {
        if ($authToken === null) {
            throw new BadRequestException('Access denied');
        }

        $user = $this->userRepo->getUserByAuthToken($authToken);
        if ($user === null) {
            throw new BadRequestException('Access denied');
        }

    }
}
