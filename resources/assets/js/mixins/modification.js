/* Làm Mixin để xài chung ở Question.vue và Answer.vue */
import Vote from '../components/Vote.vue';
import UserInfo from '../components/UserInfo.vue';
import MEditor from '../components/MEditor.vue';

import highlight from './highlight'
import destroy from './destroy'

export default {
    mixins: [highlight, destroy],

    components: { Vote, UserInfo, MEditor },

    data() {
        return {
            editing: false,
        };
    },

    methods: {
        edit() {
            this.setEditCache();
            /*this.beforeEditCache = {
                title: this.title,
                body: this.body
            };*/

            this.editing = true;
        },

        cancel() {
            this.restoreFromCache();
            /*this.title = this.beforeEditCache.title;
            this.body = this.beforeEditCache.body;*/

            this.editing = false;
        },

        update() {
            axios
                .put(this.endpoint, this.payload() /*{
                    title: this.title,
                    body: this.body
                }*/)
                .catch(response => {
                    this.$toast.error(response.data.message, 'Error', { timeout: 3000 });
                })
                .then(({ data }) => {
                    this.bodyHtml = data.body_html;
                    this.$toast.success(data.message, 'Success', {  timeout: 3000  });
                    this.editing = false;

                    // this.highlight(); // WHY IS THIS NOT WORKING?
                })
                .then(() => this.highlight());
        },

        /* Những methods phải define ở chỗ xài mixin này */
        setEditCache() {},
        restoreFromCache() {},
        payload() {},
    }
}