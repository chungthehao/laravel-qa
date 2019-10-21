/* Làm Mixin để xài chung ở Question.vue và Answer.vue */
import highlight from './highlight'

export default {
    mixins: [highlight],

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
                        this.delete();

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ],
            });
        },

        /* Những methods phải define ở chỗ xài mixin này */
        setEditCache() {},
        restoreFromCache() {},
        payload() {},
        delete() {}
    }
}