<a href="" title="Click to mark as favorite question (Click again to undo)"
   class="mt-3 favorite {{ Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '') }}"
   onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $model->id }}').submit();">
    <i class="fas fa-star fa-2x"></i>
    <span class="favorites-count">{{ $model->favorites_count }}</span>
</a>
<form id="favorite-question-{{ $model->id }}" action="/questions/{{ $model->id }}/favorites" method="post" style="display: none;">
    @csrf

    @if($model->is_favorited)
        @method('delete')
    @endif
</form>