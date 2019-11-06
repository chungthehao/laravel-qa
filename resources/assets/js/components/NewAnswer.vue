<template>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>

                    <hr>

                    <form @submit.prevent="create">
                        <div class="form-group">
                            <m-editor :body="body" name="new-answer">
                                <textarea v-model="body" name="body" id="" rows="7" class="form-control" required></textarea>
                            </m-editor>
                        </div>
                        <div class="form-group text-right">
                            <button v-bind:disabled="isInvalid" type="submit" class="btn btn-lg btn-outline-primary">
                                <spinner :small="true" v-if="$root.loading" :min-width="57" />
                                <span v-else>Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MEditor from './MEditor';

    export default {
        props: ['questionId'],
        components: { MEditor },
        methods: {
            create() {
                axios
                    .post(`/questions/${this.questionId}/answers`, {
                        body: this.body
                    })
                    .then(res => {
                        this.$toast.success(res.data.message, "Success");
                        this.body = '';
                        this.$emit('created', res.data.answer);
                    })
                    .catch(error => {
                        this.$toast.error(error.response.data.message, 'Error');
                    });
            }
        },

        data() {
            return {
                body: '',
            };
        },

        computed: {
            isInvalid() {
                return !this.signedIn || this.body.trim().length < 1;
            }
        }
    }
</script>