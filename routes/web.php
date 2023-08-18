<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BagController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\Trip_LogController;

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

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function()
{
    // User account routes
    /*Route::get('user/{id}', [UserController::class,'show'])->name('user');*/
    Route::get('users', [UserController::class,'index'])->name('users');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{id}', [UserController::class,'edit'])->name('user.edit');
    Route::post('user/update/{id}', [UserController::class,'update'])->name('user.update');
    Route::get('user/delete/{id}', [UserController::class,'destroy'])->name('user.delete');


    // Bags routes
    Route::get('bags/{id}', [BagController::class,'show'])->name('bag');
    Route::get('bags', [BagController::class,'index'])->name('bags');
    Route::get('bag/create', [BagController::class, 'create'])->name('bag.create');
    Route::post('bags/store', [BagController::class, 'store'])->name('bag.store');
    Route::get('bags/edit/{id}', [BagController::class,'edit'])->name('bag.edit');
    Route::post('bags/update/{id}', [BagController::class,'update'])->name('bag.update');
    Route::get('bags/delete/{id}', [BagController::class,'destroy'])->name('bag.delete');


    // Item routes
    Route::get('items/{id}', [ItemController::class,'show'])->name('item');
    Route::get('items', [ItemController::class,'index'])->name('items');
    Route::get('item/create', [ItemController::class, 'create'])->name('item.create');
    Route::post('items/store', [ItemController::class, 'store'])->name('item.store');
    Route::get('items/edit/{id}', [ItemController::class,'edit'])->name('item.edit');
    Route::get('items/receive/{id}', [ItemController::class,'receive'])->name('item.receive');
    Route::get('items/receive/{id}', [ItemController::class,'receive'])->name('item.receive');
    Route::get('items/not_receive/{id}', [ItemController::class,'not_receive'])->name('item.not_receive');
    Route::post('items/update/{id}', [ItemController::class,'update'])->name('item.update');
    Route::get('items/delete/{id}', [ItemController::class,'destroy'])->name('item.delete');


    // Trip routes
    Route::get('trips/{id}', [TripController::class,'show'])->name('trip');
    Route::get('trips', [TripController::class,'index'])->name('trips');
    Route::get('trip/create', [TripController::class, 'create'])->name('trip.create');
    Route::post('trips/store', [TripController::class, 'store'])->name('trip.store');
    Route::get('trips/edit/{id}', [TripController::class,'edit'])->name('trip.edit');
    Route::get('trips/receive/{id}', [TripController::class,'receive'])->name('trip.receive');
    Route::post('trips/update/{id}', [TripController::class,'update'])->name('trip.update');
    Route::get('trips/delete/{id}', [TripController::class,'destroy'])->name('trip.delete');


    
    // Route::get('/home', [Trip_LogController::class,'index'])->name('home');
});