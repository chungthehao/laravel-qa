<template>
    <!-- v-if để đảm bảo chỉ truyền 'question' cho question component khi data đã về -->
    <div class="container" v-if="question.id">
        <question v-bind:question="question"></question>


        <!-- Trước khi có tính năng "Load more answers" -->
        <!--<answers v-bind:answers="{{ $question->answers }}" v-bind:count="{{ $question->answers_count }}"></answers>-->

        <!-- Khi implement tính năng "Load more answers" -->
        <!--<answers v-bind:question="question"></answers>-->

        <!-- ĐÃ IMPLEMENT NewAnswer COMPONENT TRONG Answers COMPONENT -->
        <!--@include('answers._create', [-->
        <!--'question' => $question-->
        <!--])-->
    </div>
</template>

<script>
import Question from '../components/Question.vue';
import Answers from '../components/Answers.vue';

export default {
    components: { Question, Answers },
    props: ['slug'],
    data() {
        return {
            question: {}
        }
    },
    mounted() {
        this.fetchQuestion();
    },
    methods: {
        fetchQuestion() {
            axios.get(`/questions/${this.slug}`).then(res => {
                const { data } = res.data;
                this.question = data;
            }).catch(err => {
                const { data } = err.response;
                console.error(data);
            });
        }
    }
}
</script>