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
                <h3 class="mt-0">
                    <router-link :to="{ name: 'questions.show', params: { slug: question.slug } }">
                        {{ question.title }}
                    </router-link>
                </h3>

                <div class="ml-auto">
                    <router-link v-if="authorize('modify', question)"
                       :to="{ name: 'questions.edit', params: { id: question.id } }"
                       class="btn btn-sm btn-outline-info">Edit</router-link>

                    <button v-if="authorize('deleteQuestion', question)"
                            class="btn btn-outline-danger btn-sm"
                            @click="destroy">Delete</button>
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
import destroy from '../mixins/destroy';
import EventBus from '../event-bus';

export default {
    mixins: [destroy],

    props: ['question'],

    methods: {
        str_plural(str, quantity) {
            return str + (quantity > 1 ? 's' : '');
        },

        // Re-define (override) the delete method
        delete() {
            // Việc xóa question này ko muốn có axios interceptor -> loading = true -> bật/tắt Questions.vue component
            // => reload lại toàn bộ component Questions
            // => Tạm thời tắt nó đi đã (lát xong bật lại)
            this.$root.disableInterceptor();

            axios.delete('/questions/' + this.question.id).then(res => {
                const { message } = res.data;
                this.$toast.success(message, 'Success');
                EventBus.$emit('deleted', this.question.id);

                this.$root.enableInterceptor(); // Bật lại axios interceptor
            }).catch(err => {
                const { data } = err.response;
                console.error(data);
            });
        }
    }
}
</script>