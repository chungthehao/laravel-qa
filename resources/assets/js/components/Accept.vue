<template>
    <div><!-- Đóng vai trò root thôi -->
        <a href="" title="Mark this answer as best answer"
           :class="classes"
           v-if="canAccept"
            @click.prevent="create">
            <i class="fas fa-check fa-2x"></i>
        </a>

        <!--Ai không là người đặt câu hỏi-->
        <!--Va cau hoi nay la best thi để icon cho ngta biết-->
        <a href="" title="The question owner accepted this answer as best answer"
           :class="classes"
           onclick="event.preventDefault();"
            v-if="accepted">
            <i class="fas fa-check fa-2x"></i>
        </a>
    </div>
</template>

<script>
    import EventBus from '../event-bus';

    export default {
        props: ['answer'],

        data() {
            return {
                isBest: this.answer.is_best,
                id: this.answer.id
            };
        },

        created() {
            // Event này là nghe từ cha đổ xuống nha (từ root)
            // Đã trực chờ sẵn nghe event này từ lúc mới hình thành instance rồi!
            // Sâu xa: communicate giữa các components với nhau.
            EventBus.$on('accepted', id => {
                this.isBest = this.id === id;
            });
        },

        methods: {
            create() {
                axios
                    .post(`/answers/${this.id}/accept`)
                    .then(res => {
                        this.$toast.success(res.data.message, 'Success', {
                            timeout: 3000,
                            position: 'bottomLeft'
                        });
                        // Cập nhật lại isBest
                        this.isBest = true;

                        EventBus.$emit('accepted', this.id);
                    });
            }
        },

        computed: {
            canAccept() {
                return this.authorize('accept', this.answer);
            },

            accepted() {
                return !this.canAccept && this.isBest;
            },

            classes() {
                return [
                    'mt-3',
                    this.isBest ? 'vote-accepted' : ''
                ];
            }
        }
    }
</script>