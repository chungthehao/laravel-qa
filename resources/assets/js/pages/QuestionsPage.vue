<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2 class="mb-0">All Questions</h2>
                            <div class="ml-auto">
                                <a href="#route('questions.create')" class="btn btn-outline-secondary">Ask Question</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!--@include('layouts._messages')-->

                        <div v-if="questions.length">
                            <question-excerpt v-for="question in questions"
                                              :question="question"
                                              :key="question.id"></question-excerpt>
                        </div>

                        <div v-else class="alert alert-warning text-center">
                            <strong>Sorry!</strong> There are no questions available.
                        </div>

                        <!-- Pagination goes here. -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import QuestionExcerpt from '../components/QuestionExcerpt.vue';

export default {
    components: { QuestionExcerpt },
    data() {
        return {
            questions: []
        }
    },
    mounted() {
        this.fetchQuestions();
    },
    methods: {
        fetchQuestions() {
            axios.get('/questions').then(res => {
                this.questions = res.data.data;
            }).catch(err => console.log(err.response.data));
        }
    }
}
</script>