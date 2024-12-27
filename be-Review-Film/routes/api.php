<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CastController;
use App\Http\Controllers\API\GenresController;
use App\Http\Controllers\API\MovieController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RolesController;
use App\Http\Controllers\API\CastmovieController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ReviewController;


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

Route::prefix('v1')->group(function () {
    Route::apiResource('casts', CastController::class);
    Route::apiResource('genres', GenresController::class);
    Route::apiResource('movies', MovieController::class);
    Route::apiResource('cast_movie', CastmovieController::class);
    Route::apiResource('role', RolesController::class)->middleware(['auth:api', 'isAdmin']);
    Route::apiResource('review', ReviewController::class)->only(['store'])->middleware(['auth:api']);
    
    //auth
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']); 
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api');
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
        Route::post('/verifikasi-akun', [AuthController::class, 'verifikasi'])->middleware('auth:api');
        
        Route::post('/generate-otp', [AuthController::class, 'generateotp'])->middleware('auth:api');
    })->middleware('api');

    //profile
    Route::post('/profile', [ProfileController::class, 'profile'])->middleware('auth:api');;
   
});

