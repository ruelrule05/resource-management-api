<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Routing\Controllers\Middleware;

class AuthController extends Controller
{
    public static function middleware(): array {
        return [
            new Middleware('auth:api', except: ['register', 'login']),
        ];
    }

    public function register(RegistrationRequest $request)
    {
        $newUser = $request->validated();

        $user = User::create($newUser);

        return response()->json(compact('user'), 201);
    }
}
