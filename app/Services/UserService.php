<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

use App\Mail\WelcomeMail;
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

  public function logout() {
    $user = auth('sanctum')->user();

    if ($user instanceof User) {
      $user->tokens()->delete();
      return response()->json(['message' => 'success'], 200);
    }

    return response()->json(['message' => 'Unauthorized'], 401);
  }

  public function createUser($data) {
    User::create($data);
    return $this->login($data);
  }

    public function getUser($id) {
    $user = User::find($id);
    if ($user instanceof User) {
      return response()->json(['user' => $user], 200);
    }

    return response()->json(['message' => 'Bad request'], 400);
  }

  public function sendVerifyEmail() {
    $user = $user = auth('sanctum')->user();
    $code = sprintf("%06d", mt_rand(0, 999999));

    $data = [
      "name" => $user->name,
      "code" => $code,
    ];

    Mail::to($user->email)->send(new WelcomeMail($data));
    Cache::forget('uesr_' . $user->id);
    Cache::put('uesr_' . $user->id, $code, now()->addMinutes(10));

    return response()->json(['message' => 'success'], 200);
  }

  public function verifyUser($data) {
    $user = auth('sanctum')->user();

    if ($user instanceof User) {
      $code = Cache::get('uesr_' . $user->id);

      if ($code === $data->code) {
        $user->markEmailAsVerified();
        return response()->json(['message' => 'success'], 200);
      }
    }

    return response()->json(['message' => 'Bad request'], 400);
  }
}

