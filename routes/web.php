<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SagmentController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\LogicController;
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

Route::get('/',[SubscriberController::class,'index'])->name('home');
Route::prefix('subsribers')->group(function(){
    Route::get('/subscriber/filter/list/{segment}',[SubscriberController::class,'getFilterdList'])->name('subscriber.filteredList');
});


Route::prefix('segment/logic')->name('segment.logic.')->group(function(){
    Route::get('/',[SagmentController::class,'index'])->name('index');
    Route::get('/create',[SagmentController::class,'create'])->name('create');
    Route::post('/store',[SagmentController::class,'store'])->name('store');
});


Route::get('/logics/api/{logic_type}',[LogicController::class,'index']);
// Route::get('/logics/create',[LogicController::class,'create']);
// Route::get('/logics/store',[LogicController::class,'store']);