@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h2 class="mb-0">{{ $question->title }}</h2>
                                <div class="ml-auto">
                                    <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Go Back</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="media">
                            <div class="d-flex flex-column vote-controls">
                                <a href="" title="This question is useful" class="vote-up">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <span class="votes-count">123</span>
                                <a href="" title="This question is not useful" class="vote-down off">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <a href="" title="Click to mark as favorite question (Click again to undo)" class="mt-3 favorite favorited">
                                    <i class="fas fa-star fa-2x"></i>
                                    <span class="favorites-count">9</span>
                                </a>
                            </div>
                            <div class="media-body">
                                {!! $question->body_html !!}

                                <div class="float-right">
                                    <span class="text-muted">Asked {{ $question->created_date }}</span>
                                    <div class="media mt-1">
                                        <a href="{{ $question->user->url }}" class="mr-2">
                                            <img src="{{ $question->user->avatar }}" alt="">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> {{-- END: MEDIA --}}
                    </div> {{-- END: CARD BODY --}}
                </div>
            </div>
        </div>

        @include('answers._index', array(
            'answers_count' => $question->answers_count,
            'answers' => $question->answers,
        ))

        @include('answers._create', [
            'question' => $question
        ])
    </div>
@endsection
