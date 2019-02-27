<?php

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');

Route::get('/dashboard', 'PagesController@dashboard')->middleware('auth')->name('dashboard');

Route::group(['prefix'=>'admin','middleware'=> ['auth', 'role:Admin']],function(){
    Route::get('/listar', 'UserController@listar')->name('contactos.listar');
    Route::get('/store', 'UserController@store')->name('contactos.store');
    Route::get('/update', 'UserController@update')->name('contactos.update');
    Route::get('/delete', 'UserController@delete')->name('contactos.delete');
});

Route::group(['prefix'=>'mensajeria','middleware'=> 'auth'],function(){
    // Route::get('/', 'PagesController@mensajeria')->name('mensajeria');
    Route::get('/listar', 'ContactoController@listar')->name('contactos.listar');
    Route::post('/store','MensajeriaController@store')->name('mensajeria.crear');
    Route::post('/edit','MensajeriaController@edit')->name('mensajeria.editar');
    Route::post('/delete','MensajeriaController@delete')->name('mensajeria.eliminar');
});

Route::group(['prefix'=>'contactos','middleware'=> 'auth'],function(){
    Route::get('/', 'PagesController@contactos')->name('contactos');
    Route::post('/listar', 'ContactoController@listar')->name('contactos.listar');
    Route::post('/storevarios', 'ContactoController@storevarios')->name('contactos.storevarios');
    Route::post('/update', 'ContactoController@update')->name('contactos.update');
    Route::post('/delete', 'ContactoController@delete')->name('contactos.delete');
    Route::get('/perfil/{contacto_id}', 'PagesController@perfilcontacto')->name('contactos.perfil');
    Route::get('/contartodos', 'ContactoController@contartodos')->name('contactos.contartodos');
});

Route::group(['prefix'=>'administrador','middleware'=> 'auth'],function(){
    // Route::get('/', 'AdminPagesController@mensajeria')->name('mensajeria');
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

Route::group(['prefix'=>'actividad','middleware'=> 'auth'],function(){
    Route::post('/listar', 'ActividadController@listar')->name('actividad.listar');
    Route::post('/store','ActividadController@store')->name('actividad.crear');
    Route::post('/update','ActividadController@update')->name('actividad.editar');
    Route::post('/delete','ActividadController@delete')->name('actividad.eliminar');
});