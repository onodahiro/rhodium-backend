<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Password;

use App\Services\UserService;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(
        UserService $userService,
    ) {
        $this->userService = $userService;
    }

    public function login(Request $request): JsonResponse {
        $request->validate([
            'name' => 'string|max:255|exists:users',
            'email' => 'string|email|max:255|exists:users',
            'password' => 'required|max:255',
        ]);

        return $this->userService->login($request->all());
    }

    public function logout(): JsonResponse {
        return $this->userService->logout();
    }

    public function createUser(Request $request): JsonResponse {
        $request->validate([
            'name' => 'required|string|min:3|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'max:255', Password::min(6)->numbers()->letters()],
        ]);

        return $this->userService->createUser($request->all());
    }

    public function getUser(Request $request) {
        return $this->userService->getUser($request->id);
    }

    public function sendVerifyEmail() {
        return $this->userService->sendVerifyEmail();
    }

    public function verifyUser(Request $request) {
        return $this->userService->verifyUser($request);
    }
}
