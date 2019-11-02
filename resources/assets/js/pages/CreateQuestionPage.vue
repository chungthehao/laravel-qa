<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2 class="mb-0">Ask Question</h2>
                            <div class="ml-auto">
                                <!--<a href="{{ route('questions.index') }}"
                                       class="btn btn-outline-secondary">Go Back</a>-->
                                <router-link :to="{ name: 'questions' }"
                                             class="btn btn-outline-secondary">Go Back</router-link>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <question-form></question-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import QuestionForm from '../components/QuestionForm';

export default {
    components: { QuestionForm },
    methods: {

    }
}
</script>