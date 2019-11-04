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

                        <div class="text-center mt-3" v-if="theNextUrl">
                            <button @click="fetch(theNextUrl)" class="btn btn-outline-secondary">Load more answers</button>
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
    import highlight from '../mixins/highlight';
    import EventBus from '../event-bus';

    export default {
        mixins: [highlight],
        props: ['question'],
        data() {
            return {
                questionId: this.question.id,
                count: this.question.answers_count,
                answers: [],
                nextUrl: null,
                excludeAnswers: []
            };
        },
        created() {
            // Được gọi sau gọi instance created
            // Thường đc dùng để fetch data từ backend API
            this.fetch(`/questions/${this.questionId}/answers`);
        },
        methods: {
            add(answer) {
                this.excludeAnswers.push(answer);
                this.answers.push(answer);
                this.count++;

                // In order to wait until VueJS has finished updating the DOM -> nextTick
                this.$nextTick(() => {
                    this.highlight(`answer-${answer.id}`);
                });

                // Để chuyển trạng thái có thể delete question hay ko?
                if (this.count === 1) {
                    EventBus.$emit('answers-count-changed', this.count);
                }
            },
            remove(index) {
                this.answers.splice(index, 1);
                this.count--;

                // Để chuyển trạng thái có thể delete question hay ko?
                if (this.count === 0) {
                    EventBus.$emit('answers-count-changed', this.count);
                }
            },
            fetch(endpoint) {
                axios
                    .get(endpoint)
                    .then(({ data }) => { // { data }: destructuring object property
                        this.answers.push(...data.data);
                        this.nextUrl = data.links.next;
                        //console.log(data);

                        // this.$nextTick: Chờ VueJS render DOM xong mới làm.
                        this.$nextTick(() => {
                            data.data.forEach(a => {
                                this.highlight(`answer-${a.id}`);
                            });
                        });
                    });
            }
        },

        computed: {
            totalAnswers() {
                return `${this.count} ${this.count > 1 ? 'Answers' : 'Answer'}`;
            },
            theNextUrl () {
                if (this.nextUrl && this.excludeAnswers.length) {
                    // this will produce:
                    // http://localhost:8000/questions/1/answers&page=1&excludes[]=1&excludes[]=2
                    return this.nextUrl + this.excludeAnswers.map(a => '&excludes[]=' + a.id).join('');
                }
                return this.nextUrl;
            }
        },

        components: { Answer, NewAnswer }
    }
</script>