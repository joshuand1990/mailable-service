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

$router->get('/api/mail', function (Request $request) {
    $mails = [];

    foreach (LogEmail::query()->get() as $mail) {
        $mails[] = [
            'id' => $mail->id,
            'name' => $mail->name,
            'email' => $mail->email,
            'subject' => $mail->subject,
            'status' => $mail->status_name,
            'transport' => strtoupper($mail->transport),
            'css' => $mail->css
        ];
    }
   return response()->json($mails);
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

$router->get('/{any:.*}', function () use ($router) {
    return view('index');
});
