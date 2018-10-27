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
                        <div class="d-flex flex-column vote-controls">
                            <a href="" title="This answer is useful" class="vote-up">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">123</span>
                            <a href="" title="This answer is not useful" class="vote-down off">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>

                            @can('accept', $answer)
                                <a href="" title="Mark this answer as best answer"
                                   class="mt-3 {{ $answer->status }}"
                                   onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $answer->id }}').submit();">
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                                <form id="accept-answer-{{ $answer->id }}" action="{{ route('answers.accept', [$answer->id]) }}" method="post" style="display: none;">
                                    @csrf

                                </form>
                            @else {{-- Ai không là người đặt câu hỏi --}}
                                @if($answer->is_best) {{-- Check xem câu trả lời này phải là best ko? Nếu phải, để icon cho ngta biết --}}
                                    <a href="" title="The question owner accepted this answer as best answer"
                                       class="mt-3 {{ $answer->status }}"
                                        onclick="event.preventDefault();">
                                        <i class="fas fa-check fa-2x"></i>
                                    </a>
                                @endif
                            @endcan
                        </div>
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
                                    <span class="text-muted">Answered {{ $answer->created_date }}</span>
                                    <div class="media mt-1">
                                        <a href="{{ $answer->user->url }}" class="mr-2">
                                            <img src="{{ $answer->user->avatar }}" alt="">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{ $answer->user->url }}">{{ $answer->user->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>{{-- END: ROW --}}

                        </div>{{-- END: MEDIA BODY --}}
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>