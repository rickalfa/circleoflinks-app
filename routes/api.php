<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmpresaController;

use App\Http\Controllers\UserController;

use App\Http\Controllers\User_perfilController;

use App\Http\Controllers\PostulacionOfertaLaboralController;

use App\Http\Controllers\OfertaLaboralController;
use App\Models\User_perfil;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::resource('/empresa', EmpresaController::class);

Route::resource('/users', UserController::class);

Route::resource('/usersperfil', User_perfilController::class);

Route::patch('/usersperfil', [User_perfilController::class, 'update']);

Route::resource('/PostulacionOfertaLaboral', PostulacionOfertaLaboralController::class);

Route::resource('/ofertalaboral', OfertaLaboralController::class);

Route::get('/users/login/{email}/{pass}', [UserController::class, 'loginUser'])->name('/users/login/');