<?php

Route::prefix('hierarchy')->group(function () {
    Route::group(['middleware' => ['web', 'auth'],
                 'namespace' => 'App\Modules\Hierarchy\Controllers'
    ], function () {
        Route::get('/h1', 'Hierarchy@H1');
        Route::get('/h2', 'Hierarchy@H2');
        Route::get('/h3', 'Hierarchy@H3');
        Route::get('/h4', 'Hierarchy@H4');
        Route::get('/output', 'Hierarchy@Output');
    });
});


Route::group(['middleware' => ['web', 'auth'],
             'namespace' => 'App\Modules\Hierarchy\Controllers'
], function () {
    Route::post('/api/hierarchy/add/h1', 'Hierarchy@addH1');
    Route::post('/api/hierarchy/add/h2', 'Hierarchy@addH2');
    Route::post('/api/hierarchy/add/h3', 'Hierarchy@addH3');
    Route::post('/api/hierarchy/add/h4', 'Hierarchy@addH4');
});