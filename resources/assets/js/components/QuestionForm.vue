<template>
    <!--<form action="{{ route('questions.store') }}" method="post">-->
    <form @submit.prevent="handleSubmit">
        <!--@csrf-->
        <!--@include('questions._form', ['submitButtonText' => 'Ask This Question'])-->

        <div class="form-group">
            <label for="question-title">Question Title</label>
            <input type="text" v-model="title"
                   class="form-control" :class="errorClass('title')"
                   id="question-title">

            <div v-if="errors['title']" class="invalid-feedback">
                <strong>{{ errors['title'][0] }}</strong>
            </div>
        </div>
        <div class="form-group">
            <label for="question-body">Content</label>
            <textarea class="form-control" :class="errorClass('body')"
                      id="question-body" rows="10" v-model="body"></textarea>

            <div v-if="errors['body']" class="invalid-feedback">
                <strong>{{ errors['body'][0] }}</strong>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-outline-primary btn-lg btn-block">{{ submitButtonText }}</button>
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            title: '',
            body: '',

            // https://vuejs.org/v2/guide/list.html#Object-Change-Detection-Caveats
            errors: {
                title: [],
                body: []
            }
        }
    },
    computed: {
        submitButtonText() {
            return 'Ask This Question';
        }
    },
    methods: {
        handleSubmit() {

        },
        errorClass(field) {
            if (this.errors[field]) {
                return this.errors[field][0] ? 'is-invalid' : '';
            }
        }
    }
}
</script>