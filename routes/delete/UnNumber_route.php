<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UnNumberController;

/*
|--------------------------------------------------------------------------
| UnNumber Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


/**
 * 採番マスタ
 */
Route::prefix('UnNumber')->name('UnNumber.')->group(function() {
    // 一覧表示
    Route::get('index', [UnNumberController::class, 'index'])->name('index');
    // 登録画面表示
    Route::get('create', [UnNumberController::class, 'create'])->name('create');
    // 登録
    Route::post('store', [UnNumberController::class, 'store'])->name('store');
    // 詳細表示
    Route::get('detail/{id}', [UnNumberController::class, 'detail'])->name('detail');
    // 編集表示
    Route::get('edit/{id}', [UnNumberController::class, 'edit'])->name('edit');
    Route::post('update', [UnNumberController::class, 'update'])->name('update');
    // 削除
    Route::post('delete', [UnNumberController::class, 'delete'])->name('delete');
});