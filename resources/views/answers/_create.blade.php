<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3>Your Answer</h3>
                </div>

                <hr>

                <form action="{{ route('questions.answers.store', [$question->id]) }}" method="post">
                    @csrf

                    <div class="form-group">
                        <textarea name="body" id="" rows="7" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"></textarea>
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('body') }}</strong>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-lg btn-outline-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>