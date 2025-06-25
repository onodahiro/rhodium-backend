<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
  public function login($data): JsonResponse {
    if (Auth::attempt($data)) {
      $user = Auth::user();

      if ($user instanceof User) {
        $token = $user->createToken('YourAppName')->plainTextToken;
        return response()->json([
          'access_token' => $token,
          'token_type' => 'Bearer',
          'user' => $user,
        ]);
      }

      return response()->json(['message' => 'Bad request'], 400);
    }

    return response()->json(['message' => 'Unauthorized'], 401);
  }

  public function logout($id) {
    $user = User::find($id);
    if ($user instanceof User) {
      $user->tokens()->delete();
      return response()->json(['message' => 'Success'], 200);
    }

    return response()->json(['message' => 'Bad request'], 400);
  }

  public function createUser($data) {
    $user = User::create($data);
    if ($user instanceof User) {
      return response()->json(['user' => $user], 200);
    }

    return response()->json(['message' => 'Bad request'], 400);
  }

    public function getUser($id) {
    $user = User::find($id);
    if ($user instanceof User) {
      return response()->json(['user' => $user], 200);
    }

    return response()->json(['message' => 'Bad request'], 400);
  }
}

