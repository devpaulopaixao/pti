<?php

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => true, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
    return redirect('login');
});

Route::get('/', function () {
    return redirect('login');
});

Route::get('/painel/{hash}', 'PtiController@painel')->name('pti.panel');
Route::post('/painel/show', 'PtiController@show')->name('pti.panel.show');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/perfil', 'ProfileController@index')->name('perfil');
    Route::post('/perfil/atualizar', 'ProfileController@update')->name('perfil.atualizar');
    Route::post('/perfil/novasenha', 'ProfileController@novaSenha')->name('perfil.novasenha');

    Route::resource('perfis','RoleController');

    Route::resource('usuarios','UserController');
    Route::post('usuariosdoperfil','UserController@getUsersByRole')->name('usuarios.com.perfil');
});
