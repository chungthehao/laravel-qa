<template>
    <div class="container">
        <question v-bind:question="question"></question>

        <!-- Trước khi dùng VueJS -->
        <!--@if($question->answers_count)-->
        <!--@include('answers._index', array(-->
        <!--'answers_count' => $question->answers_count,-->
        <!--'answers' => $question->answers,-->
        <!--))-->
        <!--@endif-->

        <!-- Trước khi có tính năng "Load more answers" -->
        <!--<answers v-bind:answers="{{ $question->answers }}" v-bind:count="{{ $question->answers_count }}"></answers>-->

        <!-- Khi implement tính năng "Load more answers" -->
        <answers v-bind:question="question"></answers>

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

        props: ['question']
    }
</script>