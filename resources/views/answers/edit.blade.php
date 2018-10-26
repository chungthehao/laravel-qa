@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1>Editing the answer for the question: <strong>{{ $question->title }}</strong></h1>
                        </div>

                        <hr>

                        <form action="{{ route('questions.answers.update', [$question->id, $answer->id]) }}" method="post">
                            @csrf
                            @method('patch')

                            <div class="form-group">
                                <textarea name="body" id="" rows="7" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}">{{ old('body', $answer->body) }}</textarea>
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-lg btn-outline-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection