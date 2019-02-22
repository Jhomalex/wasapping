<?php

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');

Route::get('/dashboard', 'PagesController@dashboard')->middleware('auth')->name('dashboard');

Route::group(['prefix'=>'mensajeria','middleware'=> 'auth'],function(){
    Route::get('/', 'PagesController@mensajeria')->name('mensajeria');
    Route::get('/listar', 'ContactoController@listar')->name('contactos.listar');
    Route::post('/store','MensajeriaController@store')->name('mensajeria.crear');
    Route::post('/edit','MensajeriaController@edit')->name('mensajeria.editar');
    Route::post('/delete','MensajeriaController@delete')->name('mensajeria.eliminar');
});

Route::group(['prefix'=>'contactos','middleware'=> 'auth'],function(){
    Route::get('/', 'PagesController@contactos')->name('contactos');
    Route::get('/listar', 'ContactoController@listar')->name('contactos.listar');
    Route::post('/store','MensajeriaController@store')->name('mensajeria.crear');
    Route::post('/edit','MensajeriaController@edit')->name('mensajeria.editar');
    Route::post('/delete','MensajeriaController@delete')->name('mensajeria.eliminar');
});

Route::group(['prefix'=>'administrador','middleware'=> 'auth'],function(){
    Route::get('/', 'AdminPagesController@mensajeria')->name('mensajeria');
    Route::get('/listar', 'MensajeriaController@listarTodos')->name('mensajeria.listar');
    Route::get('mail/send', 'MailController@send');
    Route::post('/store','MensajeriaController@store')->name('mensajeria.crear');
    Route::post('/mostrarcontactos','MensajeriaController@mostrarContactos')->name('mensajeria.mostrarContactos');
    Route::get('/contarMensajerias', 'MensajeriaController@contarMensajerias')->name('mensajeria.contarDisponibles');
    Route::get('/contarCampanias', 'MensajeriaController@contarCampanias')->name('mensajeria.contarCampanias');
    Route::get('/listarRespuesta/{mensajeria_id}', 'RespuestaController@listarTodos')->name('respuesta.listar');
    Route::get('/listarRespuestaByUser', 'RespuestaController@listarTodosByUser')->name('respuesta.listarByUser');
    Route::post('/storeRespuesta','RespuestaController@store')->name('respuesta.crear');
    Route::post('/deleteRespuesta','RespuestaController@delete')->name('respuesta.eliminar');
    Route::get('/enviarTwilio','TwilioController@enviarMensajes')->name('twilio.enviar');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
