<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{ $answers_count . ' ' . str_plural('Answer', $answers_count) }}</h2>
                </div>
                <hr>

                @include('layouts._messages')

                @foreach($answers as $answer)
                    <div class="media">
                        @include('shared._vote', [
                            'model' => $answer
                        ])

                        <div class="media-body">
                            {!! $answer->body_html !!}

                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        @can('update', $answer)
                                            <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                        @endcan
                                        @if(Auth::check() && Auth::user()->can('delete', $answer))
                                            <form class="d-inline" action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return window.confirm('Are you sure?');">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-4"></div>

                                <div class="col-4">
                                    @include('shared._author', [
                                        'model' => $answer,
                                        'label' => 'answered'
                                    ])
                                </div>
                            </div>{{-- END: ROW --}}
                        </div>{{-- END: MEDIA BODY --}}
                    </div>{{-- END: MEDIA --}}
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>