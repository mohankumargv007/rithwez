<?php

namespace App\Modules\Answers\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

use Auth;
use View;
use Session;
use Config;
use App\Modules\Answers\Models\Answers as AnswersModel;

class Answers extends Controller
{

	public static function countAnswerByQuestionId($questionId) {
	  	$answers = AnswersModel::where('question_id', $questionId)
	            ->count();        
	  	return $answers;
	}
}