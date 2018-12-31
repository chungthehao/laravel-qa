<answer v-bind:answer="{{ $answer }}" inline-template>
    <div class="media post">
        @include('shared._vote', [
            'model' => $answer
        ])

        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea v-model="body" rows="10" class="form-control" required></textarea>
                </div>
                <button class="btn btn-primary" type="submit" :disabled="isInvalid">Save</button>
                <button class="btn btn-secondary" @click="cancel" type="button">Cancel</button>
            </form>
            <div v-else>
                {{--{!! $answer->body_html !!}--}}
                <div v-html="bodyHtml"></div>

                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            @can('update', $answer)
                                <a @click.prevent="edit" href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info">Edit</a>
                            @endcan
                            @if(Auth::check() && Auth::user()->can('delete', $answer))
                                <button @click="destroy" class="btn btn-outline-danger btn-sm">Delete</button>
                            @endif
                        </div>
                    </div>

                    <div class="col-4"></div>

                    <div class="col-4">
                        {{--@include('shared._author', [--}}
                        {{--'model' => $answer,--}}
                        {{--'label' => 'answered'--}}
                        {{--])--}}
                        <user-info v-bind:model="{{ $answer }}" label="Answered"></user-info>
                    </div>
                </div>{{-- END: ROW --}}
            </div>
        </div>{{-- END: MEDIA BODY --}}
    </div>{{-- END: MEDIA --}}
</answer>