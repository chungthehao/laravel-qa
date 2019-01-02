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
                            {{--@include('shared._vote', [--}}
                                {{--'model' => $question--}}
                            {{--])--}}
                            <vote v-bind:model="{{ $question }}" name="question"></vote>

                            <div class="media-body">
                                {!! $question->body_html !!}

                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        {{--@include('shared._author', [--}}
                                            {{--'model' => $question,--}}
                                            {{--'label' => 'asked'--}}
                                        {{--])--}}
                                        <user-info v-bind:model="{{ $question }}" label="Asked"></user-info>
                                    </div>
                                </div>
                            </div>{{-- END: MEDIA BODY --}}
                        </div> {{-- END: MEDIA --}}
                    </div> {{-- END: CARD BODY --}}
                </div>
            </div>
        </div>

        @if($question->answers_count)
            @include('answers._index', array(
                'answers_count' => $question->answers_count,
                'answers' => $question->answers,
            ))
        @endif

        @include('answers._create', [
            'question' => $question
        ])
    </div>
@endsection
