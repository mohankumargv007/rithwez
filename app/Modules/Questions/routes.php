<?php

Route::group([
    'namespace' => 'App\Modules\Questions\Controllers',
], function() {
Auth::routes(['verify' => true]);
    Route::get('/questions/list', 'Questions@showQuestionList');
    Route::get('/questions/postAquestion', 'Questions@showQuestionList');
});

Route::group(['middleware' => ['web'],
			 'namespace' => 'App\Modules\Questions\Controllers'
], function () {
    Route::get('/questions/list', 'Questions@showQuestionList');
    Route::get('/questions/postAquestion', 'Questions@postQuestionPage');
    Route::post('/questions/ask', 'Questions@ask')->name('questions.ask');
    Route::get('/questions/{id}/{slug}', 'Questions@showQuestionDetail');
    Route::get('/questionsDelete/{id}/{slug}', 'Questions@deleteQuestion');
    Route::post('/questions/answer', 'Questions@answer')->name('questions.answer');
    Route::get('/tag/{tag}','Questions@showQuestionByTag');
    Route::get('/questionsVotes/{id}','Questions@voteAnswer');
    Route::get('/downVoteAnswer/{id}','Questions@downVoteAnswer');
});
