<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form class="card-body" v-if="editing" @submit.prevent="update">
                    <div class="card-title">
                        <input type="text" class="form-control form-control-lg" v-model="title">
                    </div>
                    <hr>
                    <div class="media">
                        <div class="media-body">
                            <div class="form-group">
                                <m-editor :body="body">
                                    <textarea v-model="body" rows="10" class="form-control" required></textarea>
                                </m-editor>
                            </div>
                            <button class="btn btn-primary" type="submit" :disabled="isInvalid">Save</button>
                            <button class="btn btn-secondary" @click="cancel" type="button">Cancel</button>
                        </div><!-- END: MEDIA BODY -->
                    </div><!-- END: MEDIA -->
                </form><!-- END: CARD BODY -->

                <div v-else class="card-body">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h2 class="mb-0">{{ title }}</h2>
                            <div class="ml-auto">
                                <a href="/questions" class="btn btn-outline-secondary">Go Back</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="media">
                        <vote v-bind:model="question" name="question"></vote>

                        <div class="media-body">
                            <div v-html="bodyHtml"></div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        <a v-if="authorize('modify', question)" @click.prevent="edit" href="#" class="btn btn-sm btn-outline-info">Edit</a>
                                        <button v-if="authorize('deleteQuestion', question)" @click="destroy" class="btn btn-outline-danger btn-sm">Delete</button>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <user-info v-bind:model="question" label="Asked"></user-info>
                                </div>
                            </div>
                        </div><!-- END: MEDIA BODY -->
                    </div><!-- END: MEDIA -->
                </div><!-- END: CARD BODY -->
            </div>
        </div>
    </div>
</template>

<script>
    import Vote from './Vote.vue';
    import UserInfo from './UserInfo.vue';
    import modification from '../mixins/modification';
    import MEditor from './MEditor'

    export default {
        mixins: [modification],

        components: { Vote, UserInfo, MEditor },

        props: ['question'],

        data() {
            return {
                title: this.question.title,
                body: this.question.body,
                bodyHtml: this.question.body_html,
                // editing: false, // Đã có trong mixins
                id: this.question.id,
                beforeEditCache: {}
            };
        },

        computed: {
            isInvalid() {
                return this.body.length < 1 || this.title.length < 1
            },

            endpoint() {
                return `/questions/${this.id}`;
            }
        },

        methods: {
            setEditCache() {
                this.beforeEditCache = {
                    title: this.title,
                    body: this.body
                };
            },

            restoreFromCache() {
                this.title = this.beforeEditCache.title;
                this.body = this.beforeEditCache.body;
            },

            payload() {
                return {
                    title: this.title,
                    body: this.body
                };
            },

            delete() {
                axios
                    .delete(this.endpoint)
                    .then(({ data }) => {
                        this.$toast.success(data.message, 'Success', {timeout: 2000});
                    });

                setTimeout(() => {
                    window.location.href = '/questions';
                } , 3000);
            }
        }
    }
</script>