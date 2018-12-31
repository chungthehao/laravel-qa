<script>
    export default {
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
                    .patch(`/questions/${this.questionId}/answers/${this.id}`, {
                        body: this.body
                    })
                    .then(res => {
                        console.log(res);
                        this.bodyHtml = res.data.body_html;
                        this.editing = false;
                        alert(res.data.message);
                    })
                    .catch(err => {
                        console.log('Something went wrong!');
                        console.log(err.response);
                        alert(err.response.data.message);
                    });
            }
        },
        computed: {
            isInvalid() {
                return this.body.trim().length === 0;
            }
        }
    }
</script>