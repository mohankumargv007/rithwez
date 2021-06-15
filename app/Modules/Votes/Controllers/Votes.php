<?php

namespace App\Modules\Votes\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

use Auth;
use View;
use Session;
use Config;
use App\Modules\Questions\Models\Question as QuestionsModel;
use App\Modules\Tags\Models\Tag as TagsModel;
use App\Modules\Votes\Models\UserVotes as UserVotes;

class Votes extends Controller
{

public static function countUpVoteByUserAndVoteId($question_id, $user_id, $vote_category ) {
	  	$up_vote = UserVotes::where('question_id', $question_id)
	          ->where('vote_type', Config::get('constants.VOTE_TYPE.UP_VOTE')) 
	         // ->where('vote_category', $vote_category)              
	          ->count();
	  	return $up_vote;
	}    

	public static function countDownVoteByUserAndVoteId($question_id, $user_id, $vote_category ) {
	  	$up_vote = UserVotes::where('question_id', $question_id)
	          ->where('vote_type', Config::get('constants.VOTE_TYPE.DOWN_VOTE'))   
	         // ->where('vote_category', $vote_category)           
	          ->count();
	  	return $up_vote;
	}

	public static function countUpVoteByVoteId($question_id, $vote_category ) {
	  	$up_vote = UserVotes::where('question_id', $question_id)
	          ->where('vote_type', Config::get('constants.VOTE_TYPE.UP_VOTE')) 
	        //  ->where('vote_category', $vote_category)              
	          ->count();
	  	return $up_vote;
	}

	public static function countDownVoteByVoteId($question_id, $vote_category ) {
	  	$up_vote = UserVotes::where('question_id', $question_id)
	          ->where('vote_type', Config::get('constants.VOTE_TYPE.DOWN_VOTE'))   
	        //  ->where('vote_category', $vote_category)           
	          ->count();
	  	return $up_vote;
	}
}