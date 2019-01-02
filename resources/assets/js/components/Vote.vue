<template>
    <div class="d-flex flex-column vote-controls">
        <a href="" @click.prevent="voteUp" v-bind:title="title('up')"
           class="vote-up" v-bind:class="classes"> <!-- tự động vậy class="vote-up off" nếu chưa sign in -->
            <i class="fas fa-caret-up fa-3x"></i>
        </a>

        <span class="votes-count">{{ votesCount }}</span>

        <a href="" @click.prevent="voteDown" v-bind:title="title('down')"
           class="vote-down" v-bind:class="classes">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>

        <favorite v-if="name === 'question'" v-bind:question="model"></favorite>
        <accept v-if="name === 'answer'" v-bind:answer="model"></accept>
    </div>
</template>

<script>
    import Favorite from './Favorite';
    import Accept from './Accept';

    export default {
        components: {
            Favorite,
            Accept
        },

        props: ['name', 'model'],

        data() {
            return {
                votesCount: this.model.votes_count,
                id: this.model.id // id của question hoặc answer
            };
        },

        computed: {
            classes() {
                return this.signedIn ? '' : 'off';
            },
            endpoint() {
                return `/${this.name}s/${this.id}/vote`;
            }
        },

        methods: {
            title(voteType) {
                let titles = {
                    up: `This ${this.name} is useful`,
                    down: `This ${this.name} is not useful`
                };
                return titles[voteType];
            },

            voteUp() {
                return this._vote(1);
            },

            voteDown() {
                return this._vote(-1);
            },

            _vote(vote) {
                // Nếu chưa đăng nhập thì hiện warning và dừng
                if ( ! this.signedIn) {
                    this.$toast.warning(`Please login to vote the ${this.name}!`, 'Warning', {
                        timeout: 3000,
                        position: 'bottomLeft'
                    });
                    return;
                }

                axios
                    .post(this.endpoint, { vote })
                    .then(res => {
                        this.$toast.success(res.data.message, 'Success', {
                            timeout: 3000,
                            position: 'bottomLeft'
                        });

                        this.votesCount = res.data.votesCount;
                    });
            }
        }
    }
</script>