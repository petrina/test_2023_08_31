<?php

namespace App\Http\Middleware;

use App\Exceptions\BadRequestException;
use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{

    private UserService $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws BadRequestException
     */
    public function handle(Request $request, Closure $next): Response
    {

        $this->userService->checkAuthToken($request->header('auth-token'));

//        if (
//            !isset($headers['authorization'])
//            || !isset($headers['apiuser'])
//            || !array_key_exists($headers['apiuser'][0], ConstAccessTokensHelper::ACCESS_TOKENS)
//        ) {
//            throw new BadRequestException('Access error');
//        } else if (ConstAccessTokensHelper::ACCESS_TOKENS[$headers['apiuser'][0]] != $headers['authorization'][0]) {
//            throw new BadRequestException('Access error');
//        }
//        return $next($request);
        return $next($request);
    }
}
