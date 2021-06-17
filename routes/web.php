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

use Domain\Application\Model\LogEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;

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
    $mail = LogEmail::create([
        'name' => $request->get('name'), 'email' => $request->get('email'), 'subject' =>  $request->get('subject'), 'body' => $request->get('body')
        ,'transport' => 'tbd'
    ]);
    Queue::push(new \App\Jobs\SendTransactionalEmailJob($mail->toMessage()));
});
