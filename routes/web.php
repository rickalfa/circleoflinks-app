<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsappApi\WspbController;
use App\Http\Controllers\WhatsappApi\WspSendMessageController;

use App\Http\Controllers\Web\UserAppController as UserAppWeb;
use App\Http\Controllers\Web\UserAppContactController as ContactsApp;

use App\Http\Controllers\AgentController;

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


Route::get('/admindashboard',function(){

    return view('dashboard');

});


Route::get('/admindashboard/user',[UserAppWeb::class, 'index'])->name('/admindashboard/user');

Route::get('/admindashboard/user/{id}',[UserAppWeb::class, 'show'])->name('/admindashboard/user/');

/**
 * RUTAS CONVERSATIONS USER 
 */

 Route::get('/admindashboard/userconversation/{id}',[UserAppWeb::class, 'conversations'])->name('/admindashboard/userconversation/');
 Route::get('/admindashboard/userconversation-detail/{id}',[UserAppWeb::class, 'conversationDetail'])->name('/admindashboard/userconversation-detail/');
 
 


/*******************************************************************
 * RUTAS  AGENTE BOTS de Respuesta para Chats
 */
Route::get('/admindashboard/bots-r',[AgentController::class, 'index'])->name('/admindashboard/bots-r');
Route::get('/admindashboard/bots-r/{id}',[AgentController::class, 'show'])->name('/admindashboard/bots-r/');
Route::get('/admindashboard/bots-r-fabric',[AgentController::class, 'create'])->name('/admindashboard/bots-r-fabric');
Route::post('/admindashboard/bots-r',[AgentController::class, 'store'])->name('/admindashboard/bots-r');

/**
 * RUTAS  Contact Usuarios que contactaron por WSP a la APP
 */

 Route::get('/admindashboard/contacts', [ContactsApp::class, 'index'])->name('/admindashboard/contacts');



Route::get('/login', function (){

    return view('auth.login');

});


/**
 * rutas donde se conecta la Plataforma de META Whatssap API para autenticar la App 
 *  se utiliza WebHook
 */
Route::get('/wspservice', [WspbController::class, 'webhook']);

Route::post('/wspservice', [WspbController::class, 'recibir']);


Route::get('/sendmessage', [WspSendMessageController::class, 'sendmessage']);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/accesstoken', [ProfileController::class, 'showAccessToken'])->name('/profile/accesstoken');
});

require __DIR__.'/auth.php';
