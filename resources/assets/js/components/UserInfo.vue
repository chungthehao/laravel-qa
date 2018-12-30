<template>
    <div class="">
        <span class="text-muted">{{ postDate }}</span>
        <div class="media mt-1">
            <a :href="user.url" class="mr-2">
                <img :src="user.avatar" alt="">
            </a>
            <div class="media-body mt-1">
                <a :href="user.url">{{ user.name }}</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['model', 'label'], // Truyền tham số vô component
        // <user-info model="..." label="..."></user-info>

        computed: {
            postDate() {
                return this.label + ' ' + this.model.created_date;
            }
        },

        data() {
            return {
                user: this.model.user
            };
        }
    }
</script>