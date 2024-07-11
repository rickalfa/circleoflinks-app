<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsappApi\WspbController;

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

});


/**
 * rutas donde se conecta la Plataforma de META Whatssap API para autenticar la App 
 *  se utiliza WebHook
 */
Route::get('/wspservice', [WspbController::class, 'webhook']);

Route::post('/wspservice', [WspbController::class, 'recibir']);




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/accesstoken', [ProfileController::class, 'showAccessToken'])->name('/profile/accesstoken');
});

require __DIR__.'/auth.php';
