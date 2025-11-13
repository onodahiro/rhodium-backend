<?php
/** @noinspection PhpUndefinedVariableInspection */
namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\ {
  Auth,
  Mail,
  Cache,
  Hash,
};

use App\Mail\CodeMail;
use App\Models\User;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
  public function callWithCheckPass(Request $request, $func) {
    $user = auth('sanctum')->user();

    if (Hash::check($request->password, $user->password)) {
      return self::{$func}($user, $request);
    }

    return response()->json(['message' => 'Wrong password'], 400);
  }

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
      return response()->json(['message' => 'Success'], 200);
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

  public function sendVerifyCode() {
    $user = $user = auth('sanctum')->user();

    if ($user->email_verified_at) {
      return response()->json(['message' => 'The email alredy verified'], 400);
    }

    $cacheKey = 'uesr_email_' . $user->id;
    $code = sprintf("%06d", mt_rand(0, 999999));

    $data = [
      "name" => $user->name,
      "code" => $code,
    ];

    Mail::to($user->email)->send(new CodeMail($data));
    Cache::forget($cacheKey);
    Cache::put($cacheKey, $code, now()->addMinutes(10));

    return response()->json(['message' => 'Success'], 200);
  }

  public function verifyEmail(Request $request) {
    $user = auth('sanctum')->user();
    $cacheKey = 'uesr_email_' . $user->id;

    if (!Cache::has($cacheKey)) {
      return response()->json(['message' => 'The verification code has expired'], 400);
    }

    $code = Cache::get('uesr_email_' . $user->id);
    
    if ($code === $request->code) {
      if ($user instanceof User) $user->markEmailAsVerified();
      return response()->json(['message' => 'Verified'], 200);
    }
    
    return response()->json(['message' => 'Wrong code'], 400);
  }

  public static function changeEmail($user, $request) {
    $user->update([
      'email' => $request->email,
      'email_verified_at' => null
    ]);

    return response()->json(['message' => 'Success'], 200);
  }

  public static function changePassword($user, $request) {
    if (Hash::check($request->newPassword, $user->password)) {
      return response()->json(['message' => __('passwords.must_diff')], 400);
    }
  
    $user->update([
      'password' => Hash::make($request->newPassword),
    ]);

    return response()->json(['message' => 'Success'], 200);
  }

  public static function sendLostPassEmail(Request $request) {
    $user = User::where('email', $request->email)->first();

    if (!$user) {
      return response()->json(['message' => 'User not found'], 400);
    }

    $cacheKey = 'uesr_pass_' . $user->id;
    $code = sprintf("%06d", mt_rand(0, 999999));
    $userToChangePass = $request->email . $code;

    $data = [
      "name" => $user->name,
      "code" => $code,
    ];

    Mail::to($user->email)->send(new CodeMail($data));
    Cache::forget($cacheKey);
    Cache::put($userToChangePass, $user->id, now()->addMinutes(30));

    return response()->json(['message' => 'Success'], 200);
  }

  public function checkLostPassCode(Request $request) {
    $cacheKey = $request->email . $request->code;
    $userId = Cache::get($cacheKey);
    $user = User::find($userId);
    dump($cacheKey);
    dd($userId);
    if ($user instanceof User) {
        $token = $user->createToken('YourAppName')->plainTextToken;
        return response()->json([
          'message' => 'Aproved',
          'access_token' => $token,
          'token_type' => 'Bearer',
          'user' => $user,
        ]);
    }

    return response()->json(['message' => 'Bad request'], 400);
  }

  public function setLostPassword(Request $request) {
    $user = auth('sanctum')->user();
    $cacheKey = $user->email . $request->code;
    $userId = Cache::get($cacheKey);

    if ($userId === $user->id) {
      $user->update([
        'password' => Hash::make($request->newPassword),
      ]);

      return response()->json(['message' => 'Success'], 200);
    }
    return response()->json(['message' => 'Bad request'], 400);
  }
}
