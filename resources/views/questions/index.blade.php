@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2 class="mb-0">All Questions</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">Ask Question</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('layouts._messages')

                        @foreach($questions as $question)
                            <div class="media">
                                <div class="d-flex flex-column counters mr-5 text-center">
                                    <div class="vote">
                                        <strong>{{ $question->votes_count }}</strong> {{ str_plural('vote', $question->votes_count) }}
                                    </div>
                                    <div class="answer status {{ $question->status }}">
                                        <strong>{{ $question->answers_count }}</strong> {{ str_plural('answer', $question->answers_count) }}
                                    </div>
                                    <div class="view mt-3">
                                        {{ $question->views . ' ' . str_plural('view', $question->views) }}
                                    </div>
                                </div>

                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <h3 class="mt-0"><a href="{{ $question->url }}">{{ $question->title }}</a></h3>
                                        <div class="ml-auto">
                                            @can('update', $question)
                                                <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                            @endcan
                                            @if(Auth::check() && Auth::user()->can('delete', $question))
                                                <form class="d-inline" action="{{ route('questions.destroy', $question->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return window.confirm('Are you sure?');">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="lead">
                                        Asked by <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                        <small class="text-muted">{{ $question->created_date }}</small>
                                    </p>
                                    <div class="excerpt">
                                        {{ $question->excerpt(300) }}
                                    </div>
                                </div>
                            </div>

                            <hr>
                        @endforeach

                        {{ $questions->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
