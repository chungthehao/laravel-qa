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
                                <a href="" title="This question is useful"
                                   class="vote-up {{ Auth::guest() ? 'off' : '' }}"
                                   onclick="event.preventDefault();
                                            document.getElementById('up-vote-question-{{ $question->id }}').submit();">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <form id="up-vote-question-{{ $question->id }}" action="/questions/{{ $question->id }}/vote" method="post" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="vote" value="1">
                                </form>

                                <span class="votes-count">{{ $question->votes_count }}</span>

                                <a href="" title="This question is not useful"
                                   class="vote-down  {{ Auth::guest() ? 'off' : '' }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('down-vote-question-{{ $question->id }}').submit();">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <form id="down-vote-question-{{ $question->id }}" action="/questions/{{ $question->id }}/vote" method="post" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="vote" value="-1">
                                </form>

                                <a href="" title="Click to mark as favorite question (Click again to undo)"
                                   class="mt-3 favorite {{ Auth::guest() ? 'off' : ($question->is_favorited ? 'favorited' : '') }}"
                                   onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $question->id }}').submit();">
                                    <i class="fas fa-star fa-2x"></i>
                                    <span class="favorites-count">{{ $question->favorites_count }}</span>
                                </a>
                                <form id="favorite-question-{{ $question->id }}" action="/questions/{{ $question->id }}/favorites" method="post" style="display: none;">
                                    @csrf

                                    @if($question->is_favorited)
                                        @method('delete')
                                    @endif
                                </form>
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
