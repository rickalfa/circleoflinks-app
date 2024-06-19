<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmpresaController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\StatusUserController;
use App\Http\Controllers\User_perfilController;
use App\Http\Controllers\UserOfertaLaboralController;
use App\Http\Controllers\UserAppController;

use App\Http\Controllers\PostulacionOfertaLaboralController;

use App\Http\Controllers\StatusOfertaLaboralController;

use App\Http\Controllers\OfertaLaboralController;
use App\Http\Controllers\UserContactController;
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

///Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
///    return $request->user();
///});


/**
 * Acceso TOKEN Sanctum
 */

 Route::middleware(['auth:sanctum'])->group(function (){



    Route::resource('/statususer', StatusUserController::class);
    Route::post('/userofertalaboral', [UserOfertaLaboralController::class, 'store']);

 

 });


 Route::post('/users', [UserAppController::class, 'store']);


Route::resource('/empresa', EmpresaController::class);
Route::patch('/empresa', [EmpresaController::class, 'update']);
Route::delete('/empresa/{id}', [EmpresaController::class, 'destroy']);


Route::get('/users', [UserAppController::class, 'index']);

Route::resource('/statususer', StatusUserController::class)->only(['show', 'index']);

Route::resource('/usersperfil', User_perfilController::class);
Route::patch('/usersperfil', [User_perfilController::class, 'update']);


Route::resource('/postulacionofertalaboral', PostulacionOfertaLaboralController::class);
Route::delete('/postulacionofertalaboral/{id}', [PostulacionOfertaLaboralController::class, 'destroy']);
Route::patch('/postulacionofertalaboral', [PostulacionOfertaLaboralController::class, 'update']);

Route::resource('/statusofertalaboral', StatusOfertaLaboralController::class);
Route::patch('/statusofertalaboral', [StatusOfertaLaboralController::class, 'update']);
Route::delete('/statusofertalaboral/{id}', [StatusOfertaLaboralController::class, 'destroy']);


Route::resource('/ofertalaboral', OfertaLaboralController::class);
Route::patch('/ofertalaboral', [OfertaLaboralController::class, 'update']);


Route::patch('/userofertalaboral', [UserOfertaLaboralController::class, 'update']);

Route::get('/userofertalaboral/{id}', [UserOfertaLaboralController::class, 'show'])->name('/userofertalaboral/{id}');
Route::get('/userofertalaboral', [UserOfertaLaboralController::class, 'index']);



Route::resource('/usercontact', UserContactController::class);
Route::get('/users/login/{email}/{pass}', [UserController::class, 'loginUser'])->name('/users/login/');