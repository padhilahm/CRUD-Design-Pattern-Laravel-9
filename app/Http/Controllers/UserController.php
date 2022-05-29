<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;

class UserController extends Controller
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(): Response
    {
        return response()
            ->view("login", [
                "title" => "Login"
            ]);
    }

    public function doLogin(LoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($this->userService->login($email, $password)) {
            return redirect('/');
        }

        return redirect('/login')->with('error', 'Email atau password salah');
    }

    public function logout()
    {
        $this->userService->logout();

        return redirect('/login');
    }
}
