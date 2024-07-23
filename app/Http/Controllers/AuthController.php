<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['logout', 'refresh', "me"]]);
    }

    public function me()
    {
        $user = Auth::user();
        return $this->sendResponse(message: "Successfully get info user", extra: ["user" => $user]);
    }

    public function refresh()
    {
        return $this->sendResponse(message: "Successfully refresh token", extra: [
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer'
            ]
        ]);
    }

    public function login(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return $this->sendError('Unauthorized', 'Wrong credentials!', Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        return $this->sendResponse(message: "Successfully Logged in!", extra: [
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return $this->sendResponse(message: 'Successfully logged out!');
    }

    public function register(AuthRequest $request)
    {

        $email = $request->email;
        try {

            if (User::where("email", $email)->exists()) {
                return $this->sendError("Bad Request", "The email has already been taken!", Response::HTTP_BAD_REQUEST);
            }

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                "role" => "store_owner"
            ]);
            $data = new UserCollection(collect($user));
            return $this->sendResponse(data: $data, message: "Successfully register new User");
        } catch (\Exception $e) {
            return $this->sendError('Internal Server Error', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
