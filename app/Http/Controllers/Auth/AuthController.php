<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login() :JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me() :JsonResponse
    {
        $user = new UserResource(auth()->user());
        return $this->response(Response::HTTP_OK, self::FETCHED, ['profile'=>$user]);
    }

    public function logout() :JsonResponse
    {
        auth()->logout();

        return $this->response(Response::HTTP_OK, 'Successfully logged out');
    }

    public function refresh() :JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token) :JsonResponse
    {
        $data = [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
        return $this->response(Response::HTTP_OK, self::FETCHED, $data);
    }
}
