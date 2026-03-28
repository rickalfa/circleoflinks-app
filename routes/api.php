<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmpresaController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\StatusUserController;
use App\Http\Controllers\UserPerfilController;
use App\Http\Controllers\UserOfertaLaboralController;
use App\Http\Controllers\UserAppController;
use App\Http\Controllers\UserAppStatusController;
use App\Http\Controllers\ProyectosController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\PostulacionOfertaLaboralController;

use App\Http\Controllers\StatusOfertaLaboralController;

use App\Http\Controllers\OfertaLaboralController;
use App\Http\Controllers\UserContactController;
use App\Models\UserPerfil;

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
 * agregamos el prefixo de nuestra version de API  
 *     V1
 */
Route::prefix('v1')->group(function () {

/**
 * Acceso TOKEN Sanctum
 */

      Route::middleware(['auth:sanctum', 'token.expiration', 'throttle:api'])->group(function (){
    Route::post('/users', [UserAppController::class, 'store']);
    Route::patch('/users', [UserAppController::class, 'update']);
         Route::post('/empresa', [EmpresaController::class, 'store']);
         Route::patch('/empresa', [EmpresaController::class, 'update']);

         Route::post('/ofertalaboral', [OfertaLaboralController::class, 'store']);
         Route::patch('/ofertalaboral', [OfertaLaboralController::class, 'update']);

         Route::post('/statusofertalaboral', [StatusOfertaLaboralController::class, 'store']);
         Route::patch('/statusofertalaboral', [StatusOfertaLaboralController::class, 'update']);

         Route::post('/statususer', [StatusUserController::class, 'store']);
         Route::patch('/statususer', [StatusUserController::class, 'update']);

         Route::post('/userofertalaboral', [UserOfertaLaboralController::class, 'store']);
         Route::patch('/userofertalaboral', [UserOfertaLaboralController::class, 'update']);

         Route::post('/postulacionofertalaboral', [PostulacionOfertaLaboralController::class, 'store']);
         Route::patch('/postulacionofertalaboral', [PostulacionOfertaLaboralController::class, 'update']);

         Route::post('/usersprofile', [UserPerfilController::class, 'store']);
         Route::patch('/usersprofile', [UserPerfilController::class, 'update']);

         Route::post('/proyectos', [ProyectosController::class, 'store']);
         Route::patch('/proyectos', [ProyectosController::class, 'update']);

         Route::post('/usercontact', [UserContactController::class, 'store']);

         Route::post('/userappstatus', [UserAppStatusController::class, 'store']);
         Route::patch('/userappstatus', [UserAppStatusController::class, 'update']);
      });


      Route::resource('/empresa', EmpresaController::class)->only(['index', 'show']);
      Route::get('empresa/{id}/ofertalaboral', [EmpresaController::class, 'showWithOffers']);

      Route::resource('/proyectos', ProyectosController::class)->only(['index', 'show']);


      Route::get('/users', [UserAppController::class, 'index']);

      Route::resource('/statususer', StatusUserController::class)->only(['show', 'index']);

      Route::resource('/postulacionofertalaboral', PostulacionOfertaLaboralController::class)->only(['index', 'show']);

      Route::resource('/statusofertalaboral', StatusOfertaLaboralController::class)->only(['index', 'show']);

      Route::get('/');
      Route::resource('/ofertalaboral', OfertaLaboralController::class)->only(['index', 'show']);
      Route::get('/ofertalaboral/{id}/empresa',[OfertaLaboralController::class, 'showOfertaLaboralWithEmpresa']);

      Route::get('/userofertalaboral/{id}', [UserOfertaLaboralController::class, 'show'])->name('/userofertalaboral/{id}');
      Route::get('/userofertalaboral', [UserOfertaLaboralController::class, 'index']);

      Route::resource('/userappstatus', UserAppStatusController::class)->only(['index', 'show']);

      Route::resource('/usercontact', UserContactController::class)->only(['index', 'show']);
      Route::get('/users/login/{email}/{pass}', [UserController::class, 'loginUser'])->name('/users/login/');



     
       
      /**
       * Register AUth
       */

       Route::post('register', [RegisteredUserController::class, 'store'])
       ->name('register');

});
