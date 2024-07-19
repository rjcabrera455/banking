<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->validated();
            $credentials = $request->only('email', 'password');

            if (!auth()->attempt($credentials)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $user = User::where('email', $request->email)->first();
            $user->tokens()->delete();
            $device = substr($request->userAgent() ?? '', 0, 255);
            $expiresAt = $request->remember_me ? null : now()->addMinutes(config('session.lifetime'));
            $accessToken = $user->createToken($device, expiresAt: $expiresAt)->plainTextToken;
            DB::commit();

            return response()->json([
                'access_token' => $accessToken,
                'message' => 'Login successful. Welcome back!',
            ], Response::HTTP_CREATED);
            
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
