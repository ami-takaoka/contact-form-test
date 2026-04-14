<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ContactController::class, 'index']);

Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/thanks', [ContactController::class, 'store']);
Route::get('/thanks', [ContactController::class, 'thanks']);

/* 管理画面 */
Route::middleware('auth')->group(function () {

    Route::get('/admin', [AdminController::class, 'index']);

    /* 検索 */
    Route::get('/search', [AdminController::class, 'index']);

    /* 検索リセット */
    Route::get('/reset', [AdminController::class, 'reset']);

    /* 既存削除（ID付き） */
    Route::delete('/delete/{id}', [AdminController::class, 'destroy']);

    /* CSVエクスポート */
    Route::get('/export', [AdminController::class, 'export']);
});

