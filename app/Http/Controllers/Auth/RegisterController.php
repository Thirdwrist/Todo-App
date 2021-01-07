<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request) :JsonResponse
    {
        $request->validate([
            'email'=> ['required', 'unique:users'],
            'password'=>['required'],
            'name'=>['required']
        ], $request->all());

        User::create([
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'name'=>$request->name
        ]);

        return $this->response(
            Response::HTTP_CREATED,
            'created successfully'
        );
    }
}
