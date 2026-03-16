<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthApiController;


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

Route::get('/', function(){
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/login', function (){

    return view('auth.login');

})->middleware('throttle:login');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/accesstoken', [ProfileController::class, 'showAccessToken'])->name('/profile/accesstoken');
});

/**
 * rutas para la Creacion de API-Keys
 * para crear API-keys debe de estar autenticado y su email verificado
 */

Route::middleware(['auth','verified'])->group(function(){

Route::get('/profile/api-tokens',[AuthApiController::class,'index'])
->name('api.tokens');

Route::post('/profile/api-tokens/create',[AuthApiController::class,'store'])
->name('api.tokens.create');

Route::delete('/profile/api-tokens/{id}',[AuthApiController::class,'destroy'])
->name('api.tokens.delete');

Route::get('/profile/api-tokens/{id}/plain',[AuthApiController::class,'showPlainToken'])
->name('api.tokens.plain');

});


require __DIR__.'/auth.php';
