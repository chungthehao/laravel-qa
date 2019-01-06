<template>
    <div class="media post">
        <vote v-bind:model="answer" name="answer"></vote>

        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea v-model="body" rows="10" class="form-control" required></textarea>
                </div>
                <button class="btn btn-primary" type="submit" :disabled="isInvalid">Save</button>
                <button class="btn btn-secondary" @click="cancel" type="button">Cancel</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>

                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            <a v-if="authorize('modify', answer)" @click.prevent="edit" href="#" class="btn btn-sm btn-outline-info">Edit</a>
                            <button v-if="authorize('modify', answer)" @click="destroy" class="btn btn-outline-danger btn-sm">Delete</button>
                        </div>
                    </div>

                    <div class="col-4"></div>

                    <div class="col-4">
                        <user-info v-bind:model="answer" label="Answered"></user-info>
                    </div>
                </div><!-- END: ROW -->
            </div>
        </div><!-- END: MEDIA BODY -->
    </div><!-- END: MEDIA -->
</template>

<script>
    import Vote from './Vote.vue';
    import UserInfo from './UserInfo.vue';

    export default {
        components: { Vote, UserInfo },
        props: ['answer'],
        data() {
            return {
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEditCache: null
            };
        },
        methods: {
            edit() {
                this.beforeEditCache = this.body;
                this.editing = true;
            },

            cancel() {
                this.body = this.beforeEditCache;
                this.editing = false;
            },

            update() {
                axios
                    .patch(this.endpoint, {
                        body: this.body
                    })
                    .then(res => {
                        console.log(res);
                        this.bodyHtml = res.data.body_html;
                        this.editing = false;
                        this.$toast.success(res.data.message, 'Success', { timeout: 3000 });
                    })
                    .catch(err => {
                        console.log('Something went wrong!');
                        console.log(err.response);
                        this.$toast.error(err.response.data.message, 'Error', { timeout: 3000 });
                    });
            },

            destroy() {
                this.$toast.question('Are you sure about that?', 'Confirmation', {
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Hey',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', (instance, toast) => {
                            axios
                                .delete(this.endpoint)
                                .then(res => {
                                    // DÙNG JQUERY XÓA TẠM
                                    // console.log($(this.$el));
                                    // $(this.$el).fadeOut(500, () => {
                                    //     this.$toast.success(res.data.message, 'Success', { timeout: 3000 });
                                    // });

                                    // CUSTOM EVENT
                                    // Tạo ở child, parent listen (còn data thì ko thể truyền ngược, one way data)
                                    this.$emit('deleted')
                                });
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ],
                });
            }
        },
        computed: {
            isInvalid() {
                return this.body.trim().length === 0;
            },
            endpoint() {
                return `/questions/${this.questionId}/answers/${this.id}`;
            }
        }
    }
</script>