@extends('layouts.app')
@section('content')

<div class="container">
	<div class="row">
		<div class="col-lg-8 left-side" id="app"> 
			<div class="card" style="margin-top: 20px;">
			    <div class="card-header">{{$question->title}}</div>
			    <div class="card-body">
			        {{ $question->content }}
			    </div>
			</div>       
			@if (Auth::check())
			<h3 style="margin-top: 20px;">Answers</h3>
			@foreach($answers as $key => $answer)
			<div class="row" style="margin-top: 20px;">
				<div class="col-lg-4">
				</div>
				<div class="col-lg-8">
					<div class="card">
					    <div class="card-header">
					        <div class="row">
					            <div class="col-md-8">
					                <span>By : {{$answer['user_name']}}</span>
					            </div>
				                <div class="col-md-2" align="right" style="cursor:pointer">
				                    <a href="/questionsVotes/{{$answer['question_id']}}"><i class="fas fa-arrow-up">Up</i>
				                    </a>
				                </div>
				                <div class="col-md-2" align="right" style="cursor:pointer">
				                    <a href="/downVoteAnswer/{{$answer['question_id']}}"><i class="fas fa-arrow-down">Down</i>
				                    </a>
				                </div>
					        </div>
					    </div>
					    <div class="card-body">
					        Answer : {{$answer['content']}}
					    </div>
					</div>  
				</div>
			</div>
			@endforeach
			<div class="row" style="display: block;margin: 100px 0px 0px 0px;">
				<form method="POST" action="{{ route('questions.answer') }}">
					{{ csrf_field() }}
					<input type="hidden" name="question_id" value="{{ $question->id }}">
					<textarea class="ckeditor" rows="4" name="answer" style="width: 100%"></textarea>
					<br/>
					<input type="submit" class="btn btn-primary" value="Post Your Answer" />
				</form>
			</div>
			@endif

		</div>
		<div class="col-lg-4 right-side">   
			<div class="info">
				<p><span class="text-grey">asked:</span> {{ $question->created_at->diffForHumans() }}</p>
				<p><span class="text-grey">viewed:</span> {{ number_format($question->views,0) }} times</p>
			</div>     
		</div>     
	</div>
</div>

@endsection