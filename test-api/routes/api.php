<?php
  
 
    use Illuminate\Support\Facades\Route;
      
    use App\Http\Controllers\Api\Service;
use GuzzleHttp\Middleware;

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
      
      
    Route::controller(Service::class)->group(function(){
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });
            
    // Route::middleware('auth:api')->group( function () {
    //     Route::get('/details/{id}', [Service::class,'details']);
    //     Route::get('/logout',[Service::class,'logout']);
    // });

    Route::group(["middleware"=>["auth:api"]
    ],function(){Route::get('/details/{id}', [Service::class,'details']);
        Route::get('/logout',[Service::class,'logout']);});