@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2 class="mb-0">Ask Question</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Go Back</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('questions.store') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="question-title">Question Title</label>
                                <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" id="question-title">
                                {{-- biến $errors luôn có ở view, rỗng hay ko thôi --}}
                                @if($errors->has('title'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="question-body">Content</label>
                                <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" name="body" id="question-body" rows="10"></textarea>
                                {{-- biến $errors luôn có ở view, rỗng hay ko thôi --}}
                                @if($errors->has('body'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-primary btn-lg btn-block">Ask This Question</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection