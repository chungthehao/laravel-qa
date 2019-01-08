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
    import modification from '../mixins/modification';

    export default {
        mixins: [modification],

        components: { Vote, UserInfo },

        props: ['answer'],

        data() {
            return {
                // editing: false, // Đã có trong mixin 'modification'
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEditCache: null
            };
        },
        methods: {
            setEditCache() {
                this.beforeEditCache = this.body;
                // this.editing = true; // Đã có trong mixin 'modification'
            },

            restoreFromCache() {
                this.body = this.beforeEditCache;
                // this.editing = false; // Đã có trong mixin 'modification'
            },

            payload() {
                return {
                    body: this.body
                };
            },

            delete() {
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
                        this.$toast.success(res.data.message, 'Success', {timeout: 2000});
                        this.$emit('deleted')
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