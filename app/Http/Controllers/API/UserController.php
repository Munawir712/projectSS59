<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Penyewa;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                // 'email' => 'required|email',
                'username' => 'required|string',
                'password' => 'required'
            ]);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Username atau password salah',
                ], 401);
            }

            // $user = User::with('penyewa')->where('email', $request->email)->first();
            $user = User::with('penyewa')->where('username', $request->username)->first();
            if (!Hash::check($request->password, $user->password)) {
                throw new Exception('Invalid credentials');
            }

            $token = $user->createToken('authToken')->plainTextToken;
            $user['token'] = $token;

            return response()->json([
                'token_type' => 'Bearer',
                'user' => $user,
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Something went wrong',
                'errors' => $error->getMessage(),
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['required', 'email', 'string', 'unique:users', 'max:255'],
                'username' => ['required', 'string', 'unique:users', 'max:255'],
                'password' => ['required', 'string', 'min:6'],
                'phone_number' => ['required', 'numeric', 'digits_between:12,13'],
                'jenis_kelamin' => ['required']
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'data tidak valid',
                    'errors' => $validator->errors(),
                ], 422);
            }

            User::create([
                'name' => $request->name,
                'email' => $request->username . "@gmail.com",
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            $user = User::where('username', $request->username)->first();
            Penyewa::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'email' => $user->email,
                'phone_number' => $request->phone_number,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            $user['token'] = $tokenResult;

            return response()->json([
                'message' => 'Register Berhasil',
                'data' => $user,
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Internal Server Error',
                'errors' => $error->getMessage(),
            ], 500);
        }
    }

    public function fetch(Request $request)
    {
        return response()->json([
            'message' => 'Data user berhasil diambil',
            'data' => $request->user(),
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }
}
