<template>
    <div class="media post">
        <div class="d-flex flex-column counters mr-5 text-center">
            <div class="vote">
                <strong>{{ question.votes_count }}</strong> {{ str_plural('vote', question.votes_count) }}
            </div>
            <div :class="['answer', 'status', question.status]">
                <strong>{{ question.answers_count }}</strong> {{ str_plural('answer', question.answers_count) }}
            </div>
            <div class="view mt-3">
                {{ question.views + ' ' + str_plural('view', question.views) }}
            </div>
        </div>

        <div class="media-body">
            <div class="d-flex align-items-center">
                <h3 class="mt-0"><a href="#question.url">{{ question.title }}</a></h3>
                <div class="ml-auto">
                    <a v-if="authorize('modify', question)"
                       href="#route('questions.edit', question.id)"
                       class="btn btn-sm btn-outline-info">Edit</a>

                    <form v-if="authorize('deleteQuestion', questions)"
                          class="d-inline"
                          action="#route('questions.destroy', question.id)"
                          method="post">
                        <!--@csrf-->
                        <!--@method('delete')-->
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return window.confirm('Are you sure?');">Delete</button>
                    </form>
                </div>
            </div>
            <p class="lead">
                Asked by <a href="#question.user.url">{{ question.user.name }}</a>
                <small class="text-muted">{{ question.created_date }}</small>
            </p>
            <div class="excerpt">
                {{ question.excerpt }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['question'],

    methods: {
        str_plural(str, quantity) {
            return str + (quantity > 1 ? 's' : '');
        }
    }
}
</script>