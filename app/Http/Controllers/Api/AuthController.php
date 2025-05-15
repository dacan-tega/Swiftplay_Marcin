<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;

class AuthController extends Controller
{
    // Đăng ký
    public function register(Request $request)
    {
        $email = isset($request->email) ? $request->email : "";
        $name = isset($request->name) ? $request->name : "";
        $password = isset($request->password) ? $request->password : "";
        if (empty($name)) {
            return response()->json([
                'success' => false,
                'message' => 'Name is required.'
            ]);
        }

        if (empty($email)) {
            return response()->json([
                'success' => false,
                'message' => 'Email is required.'
            ]);
        }

        if (empty($password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password is required.'
            ]);
        }

        // Kiểm tra email đã tồn tại chưa
        if (\App\Models\User::where('email', $request->email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Email already exists!',
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            Wallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'balance_bonus' => 0
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Register successful',
            'user' => $user->name,
        ]);
    }

    // Đăng nhập
    public function login(Request $request)
    {
        $email = isset($request->email) ? $request->email : "";
        $password = isset($request->password) ? $request->password : "";
        if (empty($email)) {
            return response()->json([
                'success' => false,
                'message' => 'Email is required.'
            ]);
        }

        if (empty($password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password is required.'
            ]);
        }
        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials']);
        }

        // Tạo remember_token duy nhất
        $token = $user->remember_token;
        if (!$user->remember_token) {
            $token = bin2hex(random_bytes(32));
            $user->remember_token = $token;
            $user->save();
        }
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'balance' => $user->wallet->balance,
            'remember_token' => $token,
            'user_name' => $user->name,
            // 'token' => $token, // Bỏ comment nếu dùng Sanctum/Passport
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->remember_token ?? null;

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Remember token is required.'
            ]);
        }

        $user = \App\Models\User::where('remember_token', $token)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token.'
            ]);
        }

        $user->remember_token = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful.'
        ]);
    }

    public static function LaunchAllGames(Request $request)
    {
        $games = Game::all();
        $token = $request->input('remember_token');

        // Validate từng biến
        if (empty($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Remember token is required.'
            ]);
        }
        $user = User::where('remember_token', $token)->first();
        if ($user == null) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }
        $launchGames = [];
        foreach ($games as $game) {
            $class = $game->provider_service;
            $nameClass = $class . $game->type . "\Http\Controllers\Site\GameController";
            $apiUrl = "https://apollo.slotgen.com/api/$game->uuid/v1";
            if (class_exists($nameClass)) {
                $playerClass = "$class$game->type\Models\\$game->type" . "Player";
                $userId = $user->id;
                $player = $playerClass::where('player_uuid', $userId)->first();
                if ($player) {
                    $launchGames[] = [
                        'game_name' => $game->name,
                        'token' => $player->uuid,
                        // 'api_url' => $apiUrl,
                    ];
                } else {
                    $gamePathJson = $nameClass::launchGameApi($user);
                    $res = (object) $gamePathJson['data'];
                    $launchGames[] = [
                        'game_name' => $game->name,
                        'token' => $res->session_id,
                        // 'api_url' => $apiUrl,
                    ];
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Class not found.'
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'launch_games' => $launchGames,
        ]);
    }
}
