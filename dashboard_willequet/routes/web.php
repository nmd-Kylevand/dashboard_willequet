<?php

use App\Http\Controllers\AmountsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::prefix('/clients')
    ->name('clients')
    ->group(function(){
        Route::get('/', [ClientController::class, 'index'])->name('.index');
        Route::get('/search', [ClientController::class, 'search'])->name('.search');
        Route::patch('/{id}', [ClientController::class, 'update'])->name('.update');
        Route::delete('/{id}', [ClientController::class, 'destroy'])->name('.destroy');
        Route::post('/', [ClientController::class,'create'])->name('.create');
    });

    Route::prefix('/ingredients')
    ->name('ingredients')
    ->group(function(){
        Route::get('/', [IngredientsController::class, 'index'])->name('.index');
        Route::patch('/{id}', [IngredientsController::class, 'update'])->name('.update');
        Route::get('/search', [IngredientsController::class, 'search'])->name('.search');
        Route::delete('/{id}', [IngredientsController::class, 'destroy'])->name('.destroy');
        Route::post('/', [IngredientsController::class, 'create'])->name('.create');
    });

    Route::prefix('/amounts')
    ->name('amounts')
    ->group(function(){
        Route::get('/', [AmountsController::class, 'index'])->name('.index');
        Route::get('/search', [AmountsController::class, 'search'])->name('.search');
        Route::get('/{id}', [AmountsController::class,'indexDetail'])->name('.indexDetail');
        Route::post('/', [AmountsController::class, 'assign'])->name('.assign');

    });

    Route::prefix('/orders')
    ->name('orders')
    ->group(function(){
        Route::get('/', [OrderController::class, 'index'])->name('.index');
        Route::get('/search',[OrderController::class,'search'])->name('.search');
        Route::post('/', [OrderController::class, 'create'])->name('.create');
        Route::get('/{id}', [OrderController::class, 'orderDetail'])->name('.detail');
        Route::post('/{id}', [OrderController::class, 'save'])->name('.save');
    });
});

require __DIR__.'/auth.php';
