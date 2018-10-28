@can('accept', $model)
    <a href="" title="Mark this answer as best answer"
       class="mt-3 {{ $model->status }}"
       onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit();">
        <i class="fas fa-check fa-2x"></i>
    </a>
    <form id="accept-answer-{{ $model->id }}" action="{{ route('answers.accept', [$model->id]) }}" method="post" style="display: none;">
        @csrf

    </form>
@else {{-- Ai không là người đặt câu hỏi --}}
@if($model->is_best) {{-- Check xem câu trả lời này phải là best ko? Nếu phải, để icon cho ngta biết --}}
<a href="" title="The question owner accepted this answer as best answer"
   class="mt-3 {{ $model->status }}"
   onclick="event.preventDefault();">
    <i class="fas fa-check fa-2x"></i>
</a>
@endif
@endcan