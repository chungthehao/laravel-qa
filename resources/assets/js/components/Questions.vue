<template>
    <div>
        <div class="card-body">
            <spinner v-if="$root.loading" />

            <div v-else-if="questions.length">
                <question-excerpt v-for="(question, idx) in questions"
                                  :question="question"
                                  :key="question.id"></question-excerpt>
            </div>

            <div v-else class="alert alert-warning text-center">
                <strong>Sorry!</strong> There are no questions available.
            </div>
        </div>

        <div class="card-footer">
            <pagination :links="links"
                        :meta="meta"></pagination>
        </div>
    </div>
</template>

<script>
import QuestionExcerpt from './QuestionExcerpt.vue';
import Pagination from './Pagination.vue';
import EventBus from '../event-bus';

export default {
    components: { QuestionExcerpt, Pagination },
    data() {
        return {
            questions: [],
            links: {},
            meta: {},
        }
    },
    mounted() {
        this.fetchQuestions();

        EventBus.$on('deleted', removedQuestionId => {
            const idx = this.questions.findIndex(q => q.id === removedQuestionId);
            this.remove(idx);
        });
    },
    watch: {
        '$route': 'fetchQuestions'
    },
    methods: {
        fetchQuestions() {
            axios.get('/questions', { params: this.$route.query }).then(res => {
                const { data, links, meta } = res.data;
                this.questions = data;
                this.links = links;
                this.meta = meta;
            }).catch(err => {
                console.log(err.response.data);
            });
        },
        remove(idx) {
            this.questions.splice(idx, 1);
            this.count--;
        }
    }
}
</script>