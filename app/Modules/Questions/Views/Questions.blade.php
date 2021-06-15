@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>All Questions</h2>
            @foreach ($questions['data'] as $question)
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <a href="/questions/{{ $question['id'] }}/{{ $question['slug'] }}" class="title">{{$question['title']}}</a>
                            </div>
                            @if($question['edit'])
                                <div class="col-md-2" align="right" style="cursor:pointer">
                                    <a href="/questionsDelete/{{ $question['id'] }}/{{ $question['slug'] }}"><i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ $question['content'] }}
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">Votes : {{$question['votes']}}</div>
                    <div class="col-lg-4">Answers : {{$question['answers']}}</div>
                </div>
            @endforeach
        </div>
        <div class="col-lg-2 py-4">
            <button class="btn btn-md btn-primary" onclick="window.location='{{ url("questions/postAquestion") }}'">Post A Question</button>
            <div style="margin-top: 20px;">
                <h3>Tags</h3>
                @foreach ($top_tags as $item)
                <p>
                  <a href="/tag/{{ $item->tag_name }}" class="item">
                    {{ $item->tag_name }}
                  </a>

                  x {{$item->total }}
                </p>
                @endforeach
                <p>
                    <a href="/questions/list" class="item">
                      All
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
