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

            <m-editor :body="body" :name="isEdit ? 'edit-question' : 'add-question'">
                <textarea class="form-control" :class="errorClass('body')"
                          id="question-body" rows="10" v-model="body"></textarea>

                <div v-if="errors['body']" class="invalid-feedback">
                    <strong>{{ errors['body'][0] }}</strong>
                </div>
            </m-editor>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-outline-primary btn-lg btn-block">{{ submitButtonText }}</button>
        </div>
    </form>
</template>

<script>
import MEditor from '../components/MEditor';
import EventBus from '../event-bus';

export default {
    props: {
        isEdit: { type: Boolean, default: false }
    },
    components: { MEditor },
    data() {
        return {
            title: '',
            body: '',

            // https://vuejs.org/v2/guide/list.html#Object-Change-Detection-Caveats
            errors: { title: [], body: [] }
        }
    },
    mounted() {
        EventBus.$on('error', errors => this.errors = errors);

        if (this.isEdit) this.fetchQuesion();
    },
    computed: {
        submitButtonText() {
            return this.isEdit ? 'Update This Question' : 'Ask This Question';
        }
    },
    methods: {
        handleSubmit() {
            this.$emit('submitted', {
                title: this.title,
                body: this.body
            });
        },
        errorClass(field) {
            if (this.errors[field]) {
                return this.errors[field][0] ? 'is-invalid' : '';
            }
        },
        fetchQuesion() {
            axios.get(`/questions/${this.$route.params.id}`).then(res => {
                const { title, body } = res.data;
                this.title = title;
                this.body = body;
            }).catch(err => {
                console.error(err.response.data);
            });
        }
    }
}
</script>