<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UnNumberController;
use App\Http\Controllers\UniqueController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\SystemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [UnNumberController::class, 'index'])->name('home');

/**
 * 採番マスタ
 */
Route::prefix('UnNumber')->name('UnNumber.')->group(function() {
   
    // 企業別の採番登録
    Route::get('edit_create', [EditController::class, 'edit_create'])->name('edit_create');
    Route::post('edit_confirm', [EditController::class, 'edit_confirm'])->name('edit_confirm');
    Route::post('edit_store', [EditController::class, 'edit_store'])->name('edit_store');
    Route::get('edit_edit/{id}', [EditController::class, 'edit_edit'])->name('edit_edit');
    Route::post('edit_update', [EditController::class, 'edit_update'])->name('edit_update');
    Route::post('edit_delete', [EditController::class, 'edit_delete'])->name('edit_delete');
    Route::get('edit_copy/{id}', [EditController::class, 'edit_copy'])->name('edit_copy');
    Route::get('edit_paste', [EditController::class, 'edit_paste'])->name('edit_paste');


    // 採番処理のみ
    Route::get('system_index', [SystemController::class, 'system_index'])->name('system_index');
    Route::post('system_create', [SystemController::class, 'system_create'])->name('system_create');
    Route::post('system_confirm', [SystemController::class, 'system_confirm'])->name('system_confirm');
    Route::post('system_store', [SystemController::class, 'system_store'])->name('system_store');



    // 検索結果を表示
    Route::get('UnNumber_index', [UnNumberController::class, 'index'])->name('index');
    
    // 登録画面表示
    Route::get('UnNumber_create', [UnNumberController::class, 'create'])->name('create');
    // 登録確認画面表示
    Route::post('UnNumber_confirm', [UnNumberController::class, 'confirm'])->name('confirm');
    // 登録
    Route::post('UnNumber_store', [UnNumberController::class, 'store'])->name('store');
    // 詳細表示
    Route::get('UnNumber_detail/{id}', [UnNumberController::class, 'detail'])->name('detail');
    // 編集表示
    Route::get('UnNumber_edit/{id}', [UnNumberController::class, 'edit'])->name('edit');
    Route::post('UnNumber_update', [UnNumberController::class, 'update'])->name('update');
    // 削除
    Route::post('UnNumber_delete', [UnNumberController::class, 'delete'])->name('delete');
});
