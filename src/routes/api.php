<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConditionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('token-name')->plainTextToken;
        return response()->json(['token' => $token]);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
});

Route::middleware((['auth:sanctum']))->group(function () {
    Route::get('/comment', [CommentController::class, 'index']);
    Route::post('/like', [LikeController::class, 'toggleLike']);
    Route::get('item/{id}/likes-count', [LikeController::class, 'getLikesCount']);
    Route::get('/like', [LikeController::class, 'index']);
    Route::get('/comments/{id}', [CommentController::class, 'index']);
    Route::post('/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
    Route::get('/purchase', [PurchaseController::class, 'index']);
    Route::post('/purchase', [PurchaseController::class, 'store']);
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::get('/my_page', [UserDataController::class, 'index']);
    Route::get('/my_page/me', [UserDataController::class, 'show']);
    Route::post('/my_page', [UserDataController::class, 'updateAddress']);
    Route::put('/my_page/me', [UserDataController::class, 'update']);
    Route::get('/item', [ItemController::class, 'index']);
    Route::get('/item/{id}', [ItemController::class, 'show']);
    Route::post('/item', [ItemController::class, 'store']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/conditions', [ConditionController::class, 'index']);
    Route::get('/user_items', [ItemController::class, 'userItems']);
});

Route::post('/register', [RegisterController::class, 'store']);
Route::get('/item', [ItemController::class, 'index']);
Route::get('/item/{id}', [ItemController::class, 'show']);