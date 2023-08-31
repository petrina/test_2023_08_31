<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string token
 * @property string $auth_token
 * @property Carbon $auth_token_life_to
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'token',
    ];

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): User
    {
        $this->token = $token;
        return $this;
    }

    public function getAuthToken(): string
    {
        return $this->auth_token;
    }

    public function setAuthToken(string $auth_token): User
    {
        $this->auth_token = $auth_token;
        return $this;
    }

    public function getAuthTokenLifeTo(): Carbon
    {
        return $this->auth_token_life_to;
    }

    public function setAuthTokenLifeTo(Carbon $auth_token_life_to): User
    {
        $this->auth_token_life_to = $auth_token_life_to;
        return $this;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }
}
