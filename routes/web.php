<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

use Domain\Application\Actions\StoreEmailAction;
use Domain\Application\Model\LogEmail;
use Illuminate\Http\Request;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/api/mail', function (Request $request) {
   return LogEmail::query()->get();
});

$router->post('/api/mail', function (Request $request) {
    $this->validate($request, [
        'email' => ['required'],
        'name' => ['required'],
        'subject' => ['required'],
        'body' => ['required']
    ]);
    new StoreEmailAction($request->get('name'), $request->get('email'), $request->get('subject'), $request->get('body'));

    return [ 'status' => 'OK' ];

});
