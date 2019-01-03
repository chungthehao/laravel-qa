<template>
    <div class="row mt-4" v-cloak v-if="count">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ totalAnswers }}</h2>
                    </div>
                    <hr>

                    <!--@include('layouts._messages')-->

                    <!--@foreach($answers as $answer)-->
                    <!--@include('answers._answer')-->
                    <!--@endforeach-->
                    <answer v-for="answer in answers" v-bind:answer="answer" v-bind:key="answer.id"></answer>
                    <!-- Kể từ Vue version 2.2 v-for phải có kèm key, ko thì sẽ lỗi -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Answer from './Answer.vue';

    export default {
        props: ['answers', 'count'],

        computed: {
            totalAnswers() {
                return `${this.count} ${this.count > 1 ? 'Answers' : 'Answer'}`;
            }
        },

        components: { Answer }
    }
</script>