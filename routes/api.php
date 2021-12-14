<?php

Route::post('login', 'AuthController@login')->name('auth.login');
Route::post('register', 'AuthController@register')->name('auth.register');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('profile', 'AuthController@profile')->name('auth.profile');
    Route::get('logout','AuthController@logout')->name('auth.logout');
    Route::get('display-menu/{menu_name}','MenuController@displayMenu')->name('menu.display');
    Route::resource('users', 'UserController')->except(['edit', 'create']);
    Route::resource('roles', 'RoleController')->except(['edit', 'create']);
    Route::resource('clients', 'ClientController')->except(['edit', 'create']);
    Route::resource('menus', 'MenuController')->except(['edit', 'create']);
});
