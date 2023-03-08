<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UnNumberController;
use App\Http\Controllers\UniqueController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\Authority\AuthorityController;
use App\Http\Controllers\Person\PersonController;
use App\Http\Controllers\RoomType\BuildingController;
use App\Http\Controllers\RoomType\RoomController;
use App\Http\Controllers\RoomType\RoomTypeController;

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

Route::get('/home', [BuildingController::class, 'Building_index'])->name('home');

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
    Route::post('Authority_copy', [AuthorityController::class, 'Authority_copy'])->name('Authority_copy');
    Route::get('Authority_paste', [AuthorityController::class, 'Authority_paste'])->name('Authority_paste');
});

/**
 * 担当者マスタ
 */
Route::prefix('Person')->name('Person.')->group(function() {
    Route::get('Person_index', [PersonController::class, 'Person_index'])->name('Person_index');
    Route::get('Person_create', [PersonController::class, 'Person_create'])->name('Person_create');
    Route::post('Person_store', [PersonController::class, 'Person_store'])->name('Person_store');
    Route::post('Person_detail', [PersonController::class, 'Person_detail'])->name('Person_detail'); 
    Route::post('Person_edit', [PersonController::class, 'Person_edit'])->name('Person_edit'); 
    Route::post('Person_destroy', [PersonController::class, 'Person_destroy'])->name('Person_destroy');
    Route::post('Person_copy', [PersonController::class, 'Person_copy'])->name('Person_copy');
    Route::get('Person_paste', [PersonController::class, 'Person_paste'])->name('Person_paste');
});






/**
 * 部屋タイプマスタ
 */
Route::prefix('RoomType')->name('RoomType.')->group(function() {
    Route::get('RoomType_index', [RoomTypeController::class, 'RoomType_index'])->name('RoomType_index');
    Route::get('RoomType_create', [RoomTypeController::class, 'RoomType_create'])->name('RoomType_create');
    Route::post('RoomType_store', [RoomTypeController::class, 'RoomType_store'])->name('RoomType_store');
    Route::post('RoomType_detail', [RoomTypeController::class, 'RoomType_detail'])->name('RoomType_detail'); 
    Route::post('RoomType_edit', [RoomTypeController::class, 'RoomType_edit'])->name('RoomType_edit'); 
    Route::post('RoomType_destroy', [RoomTypeController::class, 'RoomType_destroy'])->name('RoomType_destroy');
    Route::post('RoomType_copy', [RoomTypeController::class, 'RoomType_copy'])->name('RoomType_copy');
    Route::get('RoomType_paste', [RoomTypeController::class, 'RoomType_paste'])->name('RoomType_paste');
});

/**
 * 棟マスタ
 */
Route::prefix('Building')->name('Building.')->group(function() {
    Route::get('Building_index', [BuildingController::class, 'Building_index'])->name('Building_index');
    Route::get('Building_create', [BuildingController::class, 'Building_create'])->name('Building_create');
    Route::post('Building_store', [BuildingController::class, 'Building_store'])->name('Building_store');
    Route::post('Building_detail', [BuildingController::class, 'Building_detail'])->name('Building_detail'); 
    Route::post('Building_edit', [BuildingController::class, 'Building_edit'])->name('Building_edit'); 
    Route::post('Building_destroy', [BuildingController::class, 'Building_destroy'])->name('Building_destroy');
    Route::post('Building_copy', [BuildingController::class, 'Building_copy'])->name('Building_copy');
    Route::get('Building_paste', [BuildingController::class, 'Building_paste'])->name('Building_paste');
});

/**
 * 部屋マスタ
 */
Route::prefix('Room')->name('Room.')->group(function() {
    Route::get('Room_index', [RoomController::class, 'Room_index'])->name('Room_index');
    Route::get('Room_create', [RoomController::class, 'Room_create'])->name('Room_create');
    Route::post('Room_store', [RoomController::class, 'Room_store'])->name('Room_store');
    Route::post('Room_detail', [RoomController::class, 'Room_detail'])->name('Room_detail'); 
    Route::post('Room_edit', [RoomController::class, 'Room_edit'])->name('Room_edit'); 
    Route::post('Room_destroy', [RoomController::class, 'Room_destroy'])->name('Room_destroy');
    Route::post('Room_copy', [RoomController::class, 'Room_copy'])->name('Room_copy');
    Route::get('Room_paste', [RoomController::class, 'Room_paste'])->name('Room_paste');
});