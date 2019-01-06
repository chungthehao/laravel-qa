<template>
    <div>
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
                        <answer v-on:deleted="remove(index)" v-for="(answer, index) in answers" v-bind:answer="answer" v-bind:key="answer.id"></answer>
                        <!-- Kể từ Vue version 2.2 v-for phải có kèm key, ko thì sẽ lỗi -->

                        <div class="text-center mt-3" v-if="nextUrl">
                            <button @click="fetch(nextUrl)" class="btn btn-outline-secondary">Load more answers</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <new-answer @created="add" v-bind:question-id="questionId"></new-answer>
    </div>
</template>

<script>
    import Answer from './Answer.vue';
    import NewAnswer from './NewAnswer.vue';

    export default {
        props: ['question'],

        data() {
            return {
                questionId: this.question.id,
                count: this.question.answers_count,
                answers: [],
                nextUrl: null
            };
        },

        created() {
            // Được gọi sau gọi instance created
            // Thường đc dùng để fetch data từ backend API
            this.fetch(`/questions/${this.questionId}/answers`);
        },

        methods: {
            add(answer) {
                this.answers.push(answer);
                this.count++;
            },
            remove(index) {
                this.answers.splice(index, 1);
                this.count--;
            },
            fetch(endpoint) {
                axios
                    .get(endpoint)
                    .then(({ data }) => { // { data }: destructuring object property
                        this.answers.push(...data.data);
                        this.nextUrl = data.next_page_url;
                        //console.log(data);
                    });
            }
        },

        computed: {
            totalAnswers() {
                return `${this.count} ${this.count > 1 ? 'Answers' : 'Answer'}`;
            }
        },

        components: { Answer, NewAnswer }
    }
</script>