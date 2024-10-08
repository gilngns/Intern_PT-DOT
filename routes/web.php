<?php

use App\Http\Controllers\Api\CategoriesController as ApiCategoriesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [PostsController::class, 'index']);
    Route::resource('posts', PostsController::class);
    Route::resource('categories', CategoriesController::class);
});

Auth::routes();

Route::prefix('api')->group(function () {
    Route::get('/posts/search', [PostController::class, 'search']);
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::get('/categories', [ApiCategoriesController::class, 'index']);
});
