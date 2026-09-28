<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;





/**
* @OA\Info(
*             title="API circleoflinks", 
*             version="1.0",
*             description="API de red social de profecionales test"
* )
*
* @OA\Server(url=L5_SWAGGER_CONST_HOST)

*/
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
