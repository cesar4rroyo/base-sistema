<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Admin\InicioController@index');




//auth
Route::get('auth/login', 'Seguridad\LoginController@index')->name('login');
Route::post('auth/login', 'Seguridad\LoginController@login')->name('login_post');
Route::get('auth/logout', 'Seguridad\LoginController@logout')->name('logout');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin',  'middleware' => ['auth', 'root']], function () {
    Route::get('/', 'AdminController@index')->name('admin');
    /* Rutas de ACCESO */
    Route::get('acceso', 'AccesoController@index')->name('acceso');
    Route::post('acceso', 'AccesoController@store')->name('store_acceso');
    /* Rutas de GRUPOMENU */
    Route::get('grupomenu/create', 'GrupoMenuController@create')->name('create_grupomenu');
    Route::get('grupomenu', 'GrupoMenuController@index')->name('grupomenu');
    Route::get('grupomenu/get', 'GrupoMenuController@getGrupos')->name('get_grupo');
    Route::get('grupomenu/show/{id}', 'GrupoMenuController@show')->name('show_grupomenu');
    Route::post('grupomenu', 'GrupoMenuController@store')->name('store_grupomenu');
    Route::post('grupomenu/edit', 'GrupoMenuController@edit')->name('edit_grupomenu');
    Route::post('grupomenu/update', 'GrupoMenuController@update')->name('update_grupomenu');
    Route::post('grupomenu/destroy', 'GrupoMenuController@destroy')->name('destroy_grupomenu');

    /* Rutas de OPCIONMENU */
    Route::get('opcionmenu/create', 'OpcionMenuController@create')->name('create_opcionmenu');
    Route::get('opcionmenu', 'OpcionMenuController@index')->name('opcionmenu');
    Route::get('opcionmenu/get', 'OpcionMenuController@getOpciones')->name('get_opcion');
    Route::get('opcionmenu/show/{id}', 'OpcionMenuController@show')->name('show_opcionmenu');
    Route::post('opcionmenu', 'OpcionMenuController@store')->name('store_opcionmenu');
    Route::post('opcionmenu/edit', 'OpcionMenuController@edit')->name('edit_opcionmenu');
    Route::post('opcionmenu/update', 'OpcionMenuController@update')->name('update_opcionmenu');
    Route::post('opcionmenu/destroy', 'OpcionMenuController@destroy')->name('destroy_opcionmenu');
    /* Rutas de ROL */
    Route::get('rol/create', 'RolController@create')->name('create_rol');
    Route::get('rol', 'RolController@index')->name('rol');
    Route::get('rol/get', 'RolController@getRoles')->name('get_rol');
    Route::get('rol/show/{id}', 'RolController@show')->name('show_rol');
    Route::post('rol', 'RolController@store')->name('store_rol');
    Route::post('rol/edit', 'RolController@edit')->name('edit_rol');
    Route::post('rol/update', 'RolController@update')->name('update_rol');
    Route::post('rol/destroy', 'RolController@destroy')->name('destroy_rol');

    /* Rutas de ROLPERSONA */
    Route::get('rolpersona', 'RolPersonaController@index')->name('rolpersona');
    Route::post('rolpersona', 'RolPersonaController@store')->name('store_rolpersona');
    /* Rutas de TIPOUSUARIO */
    Route::get('tipousuario/create', 'TipoUsuarioController@create')->name('create_tipousuario');
    Route::get('tipousuario', 'TipoUsuarioController@index')->name('tipousuario');
    Route::get('tipousuario/get', 'TipoUsuarioController@getTipos')->name('get_tipo');
    Route::get('tipousuario/show/{id}', 'TipoUsuarioController@show')->name('show_tipousuario');
    Route::post('tipousuario', 'TipoUsuarioController@store')->name('store_tipousuario');
    Route::post('tipousuario/edit', 'TipoUsuarioController@edit')->name('edit_tipousuario');
    Route::post('tipousuario/update', 'TipoUsuarioController@update')->name('update_tipousuario');
    Route::post('tipousuario/destroy', 'TipoUsuarioController@destroy')->name('destroy_tipousuario');
    /* Rutas de USUARIO */
    Route::get('usuario/create', 'UsuarioController@create')->name('create_usuario');
    Route::get('usuario', 'UsuarioController@index')->name('usuario');
    Route::get('usuario/get', 'UsuarioController@getUsuarios')->name('get_usuario');
    Route::get('usuario/show/{id}', 'UsuarioController@show')->name('show_usuario');
    Route::post('usuario', 'UsuarioController@store')->name('store_usuario');
    Route::post('usuario/edit', 'UsuarioController@edit')->name('edit_usuario');
    Route::post('usuario/update', 'UsuarioController@update')->name('update_usuario');
    Route::post('usuario/destroy', 'UsuarioController@destroy')->name('destroy_usuario');
});
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'acceso']], function () {
    /* Rutas de PERSONA */
    Route::get('persona/create', 'PersonaController@create')->name('create_persona');
    Route::get('persona', 'PersonaController@index')->name('persona');
    Route::get('persona/get', 'PersonaController@getPersonas')->name('get_persona');
    Route::get('persona/show/{id}', 'PersonaController@show')->name('show_persona');
    Route::post('persona', 'PersonaController@store')->name('store_persona');
    Route::post('persona/edit', 'PersonaController@edit')->name('edit_persona');
    Route::post('persona/update', 'PersonaController@update')->name('update_persona');
    Route::post('persona/destroy', 'PersonaController@destroy')->name('destroy_persona');
    //obetener solo los clientes con RUC para combobox
    Route::get('persona/clientes/ruc', 'PersonaController@getClientesRuc')->name('getClientesRuc');
    //obetner todos los clientes
    Route::get('persona/clientes/generales', 'PersonaController@getClientesSinRuc')->name('getTodosClientes');
    //agregar persona RUC desde el checkout
    Route::post('persona/store/checkout', 'PersonaController@storeClienteRuc')->name('storeClienteRuc');
    /* Rutas de NACIONALIDAD */
    Route::get('nacionalidad/create', 'NacionalidadController@create')->name('create_nacionalidad');
    Route::get('nacionalidad', 'NacionalidadController@index')->name('nacionalidad');
    Route::get('nacionalidad/get', 'NacionalidadController@getNacionalidades')->name('get_nacionalidad');
    Route::get('nacionalidad/{id}', 'NacionalidadController@show')->name('show_nacionalidad');
    Route::post('nacionalidad', 'NacionalidadController@store')->name('store_nacionalidad');
    Route::get('nacionalidad/{id}/edit', 'NacionalidadController@edit')->name('edit_nacionalidad');
    Route::put('nacionalidad/{id}', 'NacionalidadController@update')->name('update_nacionalidad');
    Route::delete('nacionalidad/{id}/destroy', 'NacionalidadController@destroy')->name('destroy_nacionalidad');
});