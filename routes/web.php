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
Route::get('/customers/{customer_id}/detail', [\App\Http\Controllers\CustomerController::class, 'showDetail'])->name('customers.detail')->middleware('auth');
Route::post('customers/import_csv', [\App\Http\Controllers\CustomerController::class, 'importCsv'])->name('customers.import_csv')->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('job_offers', \App\Http\Controllers\JobOfferController::class)->middleware('auth');
Route::get('job_offers/delete/{id}', [App\Http\Controllers\JobOfferController::class, 'destroy'])->name('job_offers.destroy');
Route::get('/job_offers/{id}/detail', [\App\Http\Controllers\JobOfferController::class, 'showDetail'])->name('job_offers.detail')->middleware('auth');
Route::get('job_offers/invalid/list', [App\Http\Controllers\JobOfferController::class, 'showInvalids'])->name('invalid_job_offers.index')->middleware('auth');
Route::post('job_offers/import_csv', [App\Http\Controllers\JobOfferController::class, 'importCsv'])->name('job_offers.import_csv')->middleware('auth');
Route::get('/drafts', [App\Http\Controllers\DraftJobOfferController::class, 'index'])->middleware('auth')->name('draft.index');
Route::post('/draft/create', [App\Http\Controllers\DraftJobOfferController::class, 'store'])->middleware('auth')->name('draft.create');
Route::get('/draft/edit/{id}', [App\Http\Controllers\DraftJobOfferController::class, 'edit'])->middleware('auth')->name('draft.edit');
Route::post('/draft/update/{id}', [App\Http\Controllers\DraftJobOfferController::class, 'update'])->name('draft.update');
Route::get('/draft/delete/{id}', [App\Http\Controllers\DraftJobOfferController::class, 'destroy'])->name('draft.destroy');
Route::get('/draft/{id}/detail', [App\Http\Controllers\DraftJobOfferController::class, 'showDetail'])->name('draft.detail')->middleware('auth');

Route::get('/activity/edit/{id}', [App\Http\Controllers\ActivityRecordController::class, 'edit'])->name('activity.edit')->middleware('auth');
Route::post('/activity/update/{id}', [App\Http\Controllers\ActivityRecordController::class, 'update'])->name('activity.update')->middleware('auth');
