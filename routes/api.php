<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

Route::post('/register', [ApiController::class, 'register']);
Route::post('/login', [ApiController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [ApiController::class, 'me']);
    
    // Post
    Route::get('/posts', [ApiController::class, 'getPosts']);
    Route::post('/posts', [ApiController::class, 'createPost']);
    Route::put('/posts/{post}', [ApiController::class, 'updatePost']);
    Route::delete('/posts/{post}', [ApiController::class, 'deletePost']);

    // Comment
    Route::get('/posts/{post}/comments', [ApiController::class, 'getComments']);
    Route::post('/posts/{post}/comments', [ApiController::class, 'createComment']);
    Route::delete('/comments/{comment}', [ApiController::class, 'deleteComment']);

    // Tag
    Route::get('/tags', [ApiController::class, 'getTags']);
    Route::post('/tags', [ApiController::class, 'createTag']);
    Route::delete('/tags/{tag}', [ApiController::class, 'deleteTag']);

    // Like/Unlike
    Route::post('/posts/{post}/like', [ApiController::class, 'likePost']);
    Route::post('/posts/{post}/unlike', [ApiController::class, 'unlikePost']);
});





