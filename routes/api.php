<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api','prefix' => 'auth'],function () {

    Route::post('/login', [AuthController::class,'login']);
    Route::post('/register', [AuthController::class,'register']);
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/refresh', [AuthController::class,'refresh']);
});

Route::get('/posts',[PostController::class,'index'])->middleware('auth:api');
Route::get('/post/{id}',[PostController::class,'show']);
Route::post('/posts',[PostController::class,'store']);
Route::post('/post/{id}',[PostController::class,'update']);
Route::post('/posts/{id}',[PostController::class,'destroy']);


Route::get('/comments',[CommentController::class,'index'])->middleware('auth:api');
Route::get('/comment/{id}',[CommentController::class,'show']);
Route::post('/comments',[CommentController::class,'store']);
Route::post('/comment/{id}',[CommentController::class,'update']);
Route::post('/comments/{id}',[CommentController::class,'destroy']);
