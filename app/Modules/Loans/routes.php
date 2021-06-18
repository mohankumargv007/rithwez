<?php

Route::prefix('loans')->group(function () {
    Route::group(['middleware' => ['web', 'auth'],
                 'namespace' => 'App\Modules\Loans\Controllers'
    ], function () {
        Route::get('/list', 'Loans@ShowLoansTemplate');
        Route::get('/apply', 'Loans@ApplyLoanTemplate');
        Route::get('/view/{id}', 'Loans@ViewLoanDetails');
    });
});

Route::group(['middleware' => ['web', 'auth'],
             'namespace' => 'App\Modules\Loans\Controllers'
], function () {
    Route::post('/api/loans/apply', 'Loans@ApplyLoan');
    Route::put('/api/loans/approve', 'Loans@ApproveLoan');
    Route::post('/api/loans/pay', 'Loans@PayLoan');
});