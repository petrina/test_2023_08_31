<?php

namespace App\DTO;

use Carbon\Carbon;

class AuthUserDTO extends BaseDTO
{
    private string $authToken = '';
    private Carbon $currentTime;
    private Carbon $authTokenLifeTo;

    public function __construct(string $authToken, Carbon $currentTime, Carbon $authTokenLifeTo) {
        $this->authToken = $authToken;
        $this->currentTime = $currentTime;
        $this->authTokenLifeTo = $authTokenLifeTo;
    }

    public function getData(): array
    {
        return [
            'auth_token' => $this->authToken,
            'current_time' => $this->currentTime,
            'current_time_timestamp' => $this->currentTime->timestamp,
            'auth_token_life_to' => $this->authTokenLifeTo,
            'auth_token_life_to_timestamp' => $this->authTokenLifeTo->timestamp,
        ];
    }
}
