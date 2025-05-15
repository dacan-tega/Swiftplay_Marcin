<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Api\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

include_once(__DIR__ . '/groups/api/provider/vgames.php');

Route::prefix('seamless')
    ->group(function () {
        Route::post('/list', 'App\Http\Controllers\Api\SeamlessController@listGame')->name('list');
        Route::post('/launch', 'App\Http\Controllers\Api\SeamlessController@gameLaunchApi')->name('launch');
        Route::post('/history', 'App\Http\Controllers\Api\SeamlessController@historyAgent')->name('history');
        Route::post('/history_detail', 'App\Http\Controllers\Api\SeamlessController@historyDetail')->name('history_detail');
    });

Route::prefix('seamless-new')
    ->group(function () {
        Route::post('/getgames', 'App\Http\Controllers\Api\SeamlessNewController@getgames')->name('list');
        Route::post('/getlaunchurl', 'App\Http\Controllers\Api\SeamlessNewController@getlaunchurl')->name('launch');
        Route::post('/history', 'App\Http\Controllers\Api\SeamlessNewController@historyAgent')->name('history');
        Route::post('/check', 'App\Http\Controllers\Api\SeamlessNewController@check')->name('history_detail');
    });

Route::prefix('transaction')
    ->group(function () {
        Route::post('/generate-qr', [TransactionController::class, 'generateQRCode'])->name('generate-qr');
        Route::post('/verify-qr', [TransactionController::class, 'verifyUserQr'])->name('verify-qr');
        Route::post('/payout', [TransactionController::class, 'payout']);
        Route::post('/deposit', [TransactionController::class, 'deposit']);
        Route::post('/cancel', [TransactionController::class, 'cancel']);
        Route::post('/check', [TransactionController::class, 'checkTransaction']);
    });
Route::prefix('user')
    ->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/launch-games', [AuthController::class, 'LaunchAllGames'])->name('list');
    });

// Route::middleware('auth:api')->get('/user/qr', [LoginController::class, 'getUserQr']);
