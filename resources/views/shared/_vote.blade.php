@php
    if ($model instanceof App\Question) {
        $name = 'question';
        $firstURISegment = 'questions';
    } elseif ($model instanceof App\Answer) {
        $name = 'answer';
        $firstURISegment = 'answers';
    }

    $formId = $name . '-' . $model->id;
    $formAction = "/{$firstURISegment}/{$model->id}/vote";
@endphp
<div class="d-flex flex-column vote-controls">
    <a href="" title="This {{ $name }} is useful"
       class="vote-up {{ Auth::guest() ? 'off' : '' }}"
       onclick="event.preventDefault();
               document.getElementById('up-vote-{{ $formId }}').submit();">
        <i class="fas fa-caret-up fa-3x"></i>
    </a>
    <form id="up-vote-{{ $formId }}" action="{{ $formAction }}" method="post" style="display: none;">
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>

    <span class="votes-count">{{ $model->votes_count }}</span>

    <a href="" title="This {{ $name }} is not useful"
       class="vote-down  {{ Auth::guest() ? 'off' : '' }}"
       onclick="event.preventDefault();
               document.getElementById('down-vote-{{ $formId }}').submit();">
        <i class="fas fa-caret-down fa-3x"></i>
    </a>
    <form id="down-vote-{{ $formId }}" action="{{ $formAction }}" method="post" style="display: none;">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>

    @if($model instanceof App\Question)
        {{--@include('shared._favorite', [--}}
            {{--'model' => $model--}}
        {{--])--}}

        <favorite v-bind:question="{{ $model }}"></favorite>
    @elseif($model instanceof App\Answer)
        {{--@include('shared._accept_answer', [--}}
            {{--'model' => $model--}}
        {{--])--}}

        <accept v-bind:answer="{{ $model }}"></accept>
    @endif
</div>