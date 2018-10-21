@csrf

<div class="form-group">
    <label for="question-title">Question Title</label>
    <input type="text" value="{{ old('title', $question->title) }}" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" id="question-title">
    {{-- biến $errors luôn có ở view, rỗng hay ko thôi --}}
    {{--@if($errors->has('title'))--}}
    <div class="invalid-feedback">
        <strong>{{ $errors->first('title') }}</strong>
    </div>
    {{--@endif--}}
</div>
<div class="form-group">
    <label for="question-body">Content</label>
    <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" name="body" id="question-body" rows="10">{{ old('body', $question->body) }}</textarea>
    {{-- biến $errors luôn có ở view, rỗng hay ko thôi --}}
    {{--@if($errors->has('body'))--}}
    <div class="invalid-feedback">
        <strong>{{ $errors->first('body') }}</strong>
    </div>
    {{--@endif--}}
</div>
<div class="form-group">
    <button type="submit" class="btn btn-outline-primary btn-lg btn-block">{{ $submitButtonText }}</button>
</div>