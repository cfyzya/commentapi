<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth', [AuthController::class, 'getAccessToken'])->name('login');

Route::prefix('comments')->middleware('auth:sanctum')->group( function () {
    Route::post('/',            [CommentsController::class, 'create']);
    Route::get('/search/',      [CommentsController::class, 'search']);
    Route::put('/{comment}',  [CommentsController::class, 'update'])->can('update', 'comment');
    Route::get('/{comment}',  [CommentsController::class, 'getById']);
    Route::delete('/{comment}', [CommentsController::class, 'delete'])->can('delete', 'comment');;
    Route::get('/news/{news}',  [CommentsController::class, 'getByNewsId']);
});


