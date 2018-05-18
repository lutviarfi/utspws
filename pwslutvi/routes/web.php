<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });
$api=app('Dingo\Api\Routing\Router');
$api->version('v1',function($api){
    $api->get('/', function(){
      throw new
      Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException([], "Method Not Allowed");
    });
    // Default_Controller
    $api->get('categories','App\Http\Controllers\ConCategory@index');
  
    // read
    $api->get('categories/{id}','App\Http\Controllers\ConCategory@show');
  
    // Creat
    $api->post('categories','App\Http\Controllers\ConCategory@store');
  
    // Update
    $api->put('categories/{id}','App\Http\Controllers\ConCategory@update');
  
    // Delete
    $api->delete('categories/{id}','App\Http\Controllers\ConCategory@destroy');
  });
