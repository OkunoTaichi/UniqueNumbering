<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UnNumberController;
use App\Http\Controllers\UniqueController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\Authority\AuthorityController;

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
    Route::get('UnNumber_create', [UnNumberController::class, 'create'])->name('create');
    Route::post('UnNumber_confirm', [UnNumberController::class, 'confirm'])->name('confirm');
    Route::post('UnNumber_store', [UnNumberController::class, 'store'])->name('store');
    Route::get('UnNumber_detail/{id}', [UnNumberController::class, 'detail'])->name('detail');
    Route::get('UnNumber_edit/{id}', [UnNumberController::class, 'edit'])->name('edit');
    Route::post('UnNumber_update', [UnNumberController::class, 'update'])->name('update');
    Route::post('UnNumber_delete', [UnNumberController::class, 'delete'])->name('delete');
});


/**
 * 権限マスタ
 */
Route::prefix('Authority')->name('Authority.')->group(function() {
    Route::get('Authority_index', [AuthorityController::class, 'Authority_index'])->name('Authority_index'); 
    Route::post('Authority_store', [AuthorityController::class, 'Authority_store'])->name('Authority_store');
    Route::post('Authority_edit', [AuthorityController::class, 'Authority_edit'])->name('Authority_edit'); 
    Route::post('Authority_destroy', [AuthorityController::class, 'Authority_destroy'])->name('Authority_destroy');
});