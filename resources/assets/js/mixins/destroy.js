export default {
    methods: {
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

        /* Những methods phải define ở chỗ xài mixin này (Các components, các file .vue) */
        delete() {}
    }
}