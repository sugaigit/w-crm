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
Route::resource('customers', \App\Http\Controllers\CustomerController::class)->middleware('auth');
Route::post('/customers/{customer_id}/hidden', [\App\Http\Controllers\CustomerController::class, 'hide'])->name('customers.hidden')->middleware('auth');
Route::post('customers/import_csv', [\App\Http\Controllers\CustomerController::class, 'importCsv'])->name('customers.import_csv')->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('job_offers', \App\Http\Controllers\JobOfferController::class)->middleware('auth');
Route::post('job_offers/import_csv', [\App\Http\Controllers\JobOfferController::class, 'importCsv'])->name('job_offers.import_csv')->middleware('auth');
Route::get('/drafts', [App\Http\Controllers\DraftJobOfferController::class, 'index'])->middleware('auth')->name('draft.index');
Route::post('/draft/create', [App\Http\Controllers\DraftJobOfferController::class, 'store'])->middleware('auth')->name('draft.create');
Route::get('/draft/edit/{id}', [App\Http\Controllers\DraftJobOfferController::class, 'edit'])->middleware('auth')->name('draft.edit');
Route::put('/draft/update/{id}', [App\Http\Controllers\DraftJobOfferController::class, 'update'])->name('draft.update');
Route::delete('/draft/delete/{id}', [App\Http\Controllers\DraftJobOfferController::class, 'destroy'])->name('draft.destroy');
