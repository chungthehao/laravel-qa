import Prism from 'prismjs';

export default {
    methods: {
        highlight(id = '') {
            const el = id === '' ? this.$refs.bodyHtml : document.getElementById(id);

            //console.log('el', el);

            if (el) Prism.highlightAllUnder(el); // https://prismjs.com/extending.html
        }
    }
}