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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;

$router->get('/', function () use ($router) {

    Queue::push(new \App\Jobs\ExampleJob);
    return $router->app->version();
});

$router->get('/api/mail', function (Request $request) {
   return \Domain\Application\Model\LogEmail::query()->get();
});
$router->post('/api/mail/send', function (Request $request) {
    $this->validate($request, [
        'email' => ['required'],
        'name' => ['required'],
        'subject' => ['required'],
        'body' => ['required']
    ]);
});
