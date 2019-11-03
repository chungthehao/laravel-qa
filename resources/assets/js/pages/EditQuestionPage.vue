<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2 class="mb-0">Edit Question</h2>
                            <div class="ml-auto">
                                <!--<a href="{{ route('questions.index') }}"
                                       class="btn btn-outline-secondary">Go Back</a>-->
                                <router-link :to="{ name: 'questions' }"
                                             class="btn btn-outline-secondary">Go Back</router-link>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <question-form @submitted="update" :is-edit="true"></question-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import QuestionForm from '../components/QuestionForm';
    import EventBus from '../event-bus';

    export default {
        components: { QuestionForm },
        methods: {
            update(data) {
                // Ko cần truyền: Authorization -> Bearer gì gì. (Nhờ CreateFreshApiToken middleware)
                // Ko cần /api/questions (Nhờ window.axios.defaults.baseURL = window.Urls.api || 'http://localhost:8000/api';)
                axios.put(`/questions/${this.$route.params.id}`, data).then(res => {
                    const { data: { message } } = res;
                    this.$router.push({ name: 'questions' }); // Redirect back to all questions
                    this.$toast.success(message, 'Success');
                }).catch(({ response: { data: { errors } } }) => {
                    //console.error(errors);
                    if (errors) {
                        EventBus.$emit('error', errors);
                    }
                });
            }
        }
    }
</script>