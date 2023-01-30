<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', [\App\Http\Controllers\TopPageController::class, 'top_page'])->name('top_page');
Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('auth');
Route::get('/roles', \App\Http\Controllers\RoleController::class)->name('ロール一覧')->middleware('auth');
Route::resource('customers', \App\Http\Controllers\CustomerController::class);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('job_offers', \App\Http\Controllers\JobOfferController::class);
Route::post('/draft/create', [App\Http\Controllers\DraftJobOfferController::class, 'store'])->name('draft.create');
Route::get('/draft/edit/{id}', [App\Http\Controllers\DraftJobOfferController::class, 'edit'])->name('draft.edit');
Route::put('/draft/update/{id}', [App\Http\Controllers\DraftJobOfferController::class, 'update'])->name('draft.update');
Route::delete('/draft/delete/{id}', [App\Http\Controllers\DraftJobOfferController::class, 'destroy'])->name('draft.destroy');

Auth::routes();
