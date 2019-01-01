<template>
    <a href="" title="Click to mark as favorite question (Click again to undo)"
       :class="favoriteCssClasses"
        @click.prevent="toggleFavorite">
        <i class="fas fa-star fa-2x"></i>
        <span class="favorites-count">{{ count }}</span>
    </a>
</template>
<script>
    export default {
        props: ['question'],

        data() {
            return {
                isFavorited: this.question.is_favorited,
                count: this.question.favorites_count,
                // signedIn: false,
                id: this.question.id
            };
        },

        computed: {
            favoriteCssClasses() {
                return [
                    'mt-3',
                    'favorite',
                    !this.signedIn ? 'off' : (this.isFavorited ? 'favorited' : '')
                ];
            },
            endpoint() {
                return `/questions/${this.id}/favorites`;
            },
            signedIn() {
                return window.Auth.signedIn;
            }
        },

        methods: {
            toggleFavorite() {
                if ( ! this.signedIn) {
                    this.$toast.warning('Please login to favorite this question!', 'Warning', {
                        timeout: 3000,
                        position: 'bottomLeft'
                    });
                    return; // end the execution
                }
                this.isFavorited ? this.destroy() : this.create();
            },

            destroy() {
                axios
                    .delete(this.endpoint)
                    .then(res => {
                        this.count--;
                        this.isFavorited = false;
                    });
            },

            create() {
                axios
                    .post(this.endpoint)
                    .then(res => {
                        this.count++;
                        this.isFavorited = true;
                    });
            }
        }
    }
</script>