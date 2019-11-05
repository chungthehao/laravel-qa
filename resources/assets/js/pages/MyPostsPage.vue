<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <router-link class="nav-link"
                                             :to="{ name: 'my-posts' }"
                                             exact>All</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link"
                                             :to="{ name: 'my-posts', query: { type: 'questions' } }"
                                             exact>Questions</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link"
                                             :to="{ name: 'my-posts', query: { type: 'answers' } }"
                                             exact>Answers</router-link>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush" v-if="posts.length">
                            <li class="list-group-item" v-for="(post, idx) in posts" :key="post.id">
                                <div class="row">
                                    <div class="col">
                                        <span class="post-badge"
                                              :class="{ accepted: post.accepted }">{{ post.type }}</span>
                                        <span class="ml-4 votes-count"
                                              :class="{ accepted: post.accepted }">{{ post.votes_count }}</span>
                                    </div>

                                    <div class="col-md-9 text-left">
                                        {{ post.question_title }}
                                    </div>

                                    <div class="col text-right">{{ post.created_at }}</div>
                                </div>
                            </li>
                        </ul>

                        <div class="alert alert-warning" v-else>
                            <p>You have no any questions or answers.</p>
                            <p>
                                <router-link :to="{ name: 'questions.create' }">Ask Question</router-link>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    $color-green: rgba(95, 187, 126, 1);

    .votes-count {
        border: 1px solid #ddd;
        display: inline-block;
        min-width: 40px; // Số lớn còn nở ra tiếp đc
        text-align: center;

        &.accepted {
            background: $color-green;
            border-color: $color-green;
            color: white;
        }
    }

    .post-badge {
        border: 1px solid #ddd;
        display: inline-block;
        width: 25px;
        text-align: center;
        border-radius: 100%;

        &.accepted {
            border-color: $color-green;
            color: $color-green;
        }
    }
</style>

<script>
export default {
    data() {
        return {
            posts: []
        }
    },
    mounted() {
        this.fetchPosts();
    },
    methods: {
        fetchPosts() {
            axios.get('/my-posts', { params: this.$route.query }).then(res => {
                const { data } = res.data;
                this.posts = data;
            }).catch(err => {
                console.error(err.response.data);
            });
        }
    },
    watch: {
        // Khi params trên URL thay đổi thì component KHÔNG có re-render lại -> watch nó để tự mình re-render nó
        '$route': 'fetchPosts'
    }
}
</script>