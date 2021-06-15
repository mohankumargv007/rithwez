<?php

Route::group([
    'namespace' => 'App\Modules\Users\Controllers',
], function() {
    Route::get('login',  'UsersController@Login')->name('login');
    Route::get('logout', 'UsersController@logout')->name('logout');
});