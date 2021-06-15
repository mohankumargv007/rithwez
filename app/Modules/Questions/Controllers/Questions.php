<?php

namespace App\Modules\Questions\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

use Auth;
use View;
use Session;
use Config;
use DB;
use App\Modules\Questions\Models\Question as QuestionsModel;
use App\Modules\Tags\Models\Tag as TagsModel;
use App\Modules\Votes\Controllers\Votes as Votes;
use App\Modules\Answers\Controllers\Answers as Answers;
use App\Modules\Answers\Models\Answers as AnswersModel;
use App\Modules\Votes\Models\UserVotes as UserVotes;

class Questions extends Controller
{
	public static function showQuestionList() {
		$user = User::get();
		$questions = [];
		if(isset($user[0]->email_verified_at)) {
			$questions = QuestionsModel::orderBy('created_at', 'desc')->paginate(10)->toArray();

			$question_count = QuestionsModel::count();

			$questions = self::formatData($questions);

			$top_tags = self::getTopTags();
			
			$top_tags = $top_tags['data'];

			return view('Questions::Questions', compact(array('questions', 'question_count', 'top_tags')));
		} else {
			return view('auth.verify');
		}
	}

	public static function showQuestionByTag($tag) {

	  $tags = TagsModel::where('tag_name', '=', $tag)->select('id')->get()->toArray();

	  $tags = array_column($tags, 'id');

	  $questions = QuestionsModel::whereIn('id', $tags)->get()->toArray();

	  $questions['data'] = $questions;

	  $question_count = QuestionsModel::count();

	  $questions = self::formatData($questions);

	  $top_tags = self::getTopTags();
	  $top_tags = $top_tags['data'];

	  return view('Questions::Questions', compact(array('questions', 'question_count', 'top_tags')));
	}

	public static function formatData($questions) {
		foreach ($questions['data'] as $key => $question) {
			$questions['data'][$key]['votes'] = Votes::countUpVoteByVoteId($question['id'], Config::get('constants.VOTE_CATEGORY.QUESTION') )
			- Votes::countDownVoteByVoteId($question['id'], Config::get('constants.VOTE_CATEGORY.QUESTION') );
			$questions['data'][$key]['answers'] = Answers::countAnswerByQuestionId($question['id']);
			$questions['data'][$key]['edit'] = Auth::user()->id == $question['user_id'] ? 1 : 0;
		}

		return $questions;
	}

	public static function postQuestionPage(Request $request) {
		return view('Questions::PostQuestion');
	}

	public function ask(Request $request)
	{
		$inputs = $request->all();

		$question = new QuestionsModel;

		$question->title = $inputs['title'];

		$question->user_id = Auth::user()->id;

		$question->slug = str_slug($question->title, '-');
		
		$question->content = $inputs['content'];

		$question->status = Config::get('constants.QUESTION_STATUS.ACTIVE');

		$question->created_by = Auth::user()->id;

		$question->save();

		foreach (explode(',', strtolower($inputs['tag'])) as $key => $value) {
			$tag = new TagsModel;

			$tag->tag_name = $value;

			$tag->question_id = $question->id;

			$tag->status = 1;

			$tag->save();
		}

		$question_url = Config::get('constants.QUESTION_URL') . '/' . $question->id . '/' . $question->slug ;
		
		return redirect($question_url);
	}

	public static function getTopTags() {

		$tags = DB::table('tags')
		->select('tag_name', DB::raw('count(question_id) as total'))
		->groupBy('tag_name')
		->orderBy('total', 'desc')
		->paginate(10)->toArray();

		return $tags;
	}

	public function showQuestionDetail($id,$slug) {

		$currentUserId = 0;

		if(Auth::user()){
			$currentUserId = Auth::user()->id;
		}

		$question = QuestionsModel::find($id);

		if($question){
			$question->views++;
			$question->save();
		}

		$answers = AnswersModel::where('question_id', '=', $id)->get()->toArray();

		foreach ($answers as $key => $answer) {
			$user = User::find($answer['user_id'])->get()->toArray();
			$answers[$key]['user_name'] = $user[0]['first_name'].''.$user[0]['last_name'];
		}

		return view('Questions::Details', ['question' => $question,
			'currentUserId' => $currentUserId,
			'answers' => $answers,
			'isLogin' => $currentUserId > 0]);
	}

	public function deleteQuestion($id,$slug) {
		$question = QuestionsModel::find($id)->delete();
		return redirect('/questions/list');
	}

	public static function answer(Request $request)
	{
		$inputs = $request->all();

		$question = QuestionsModel::find($inputs['question_id']);

		$answer = new AnswersModel;
		$answer->content = $inputs['answer'];
		$answer->user_id = Auth::user()->id;
		$answer->question_id = $question->id;
		$answer->status = 1;
		$answer->created_by = Auth::user()->id;
		$answer->save();

		$question_url = Config::get('constants.QUESTION_URL') . '/' . $question->id . '/' . $question->slug ;

		return redirect($question_url);
	}

	public static function voteAnswer($id) {
		$vote = new UserVotes();
		$vote->question_id = $id;
		$vote->vote_type = Config::get('constants.VOTE_TYPE.UP_VOTE');
		$vote->vote_category = 1;
		$vote->user_id = Auth::user()->id;
		$vote->status = 1;
		$vote->save();

		return back();
	}

	public static function downVoteAnswer($id) {
		$vote = new UserVotes();
		$vote->question_id = $id;
		$vote->vote_type = Config::get('constants.VOTE_TYPE.DOWN_VOTE');
		$vote->vote_category = 1;
		$vote->user_id = Auth::user()->id;
		$vote->status = 1;
		$vote->save();

		return back();
	}
}
