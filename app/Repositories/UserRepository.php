<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;

class UserRepository
{

    /**
     * @param string $userEmail
     * @param string $personalToken
     * @return User|null
     */
    public function getAuthTokenByEmailAndPersonalToken(string $userEmail, string $personalToken): ?User
    {
        return User::where([
            ['email', '=', $userEmail],
            ['token', '=', $personalToken]
        ])->first();
    }

    /**
     * @param User $user
     * @param string $newToken
     * @param Carbon $tokenLifeTo
     * @return bool
     */
    public function updateAuthToken(User $user, string $newToken, Carbon $tokenLifeTo): bool
    {
        return $user->setAuthToken($newToken)
            ->setAuthTokenLifeTo($tokenLifeTo)
            ->save();
    }

    /**
     * @param string $authToken
     * @return User|null
     */
    public function getUserByAuthToken(string $authToken): ?User {
        return User::where([
            ['auth_token', '=', $authToken],
            ['auth_token_life_to', '>', Carbon::now()]
        ])->first();
    }
}
