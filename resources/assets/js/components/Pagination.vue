<template>
    <div class="row align-items-center">
        <div class="col">
            <button class="btn btn-outline-secondary"
                    :disabled="isFirst"
                    @click="prev">Newer</button>
        </div>
        <!-- 1st column -->

        <div class="col text-center">
            {{ pagesInfo }}
        </div>
        <!-- 2nd column -->

        <div class="col text-right">
            <button class="btn btn-outline-secondary"
                    :disabled="isLast"
                    @click="next">Older</button>
        </div>
        <!-- 3rd column -->
    </div>
</template>

<script>
export default {
    props: ['links', 'meta'],
    computed: {
        isFirst() {
            return this.meta.current_page === 1;
        },
        isLast() {
            return this.meta.current_page === this.meta.last_page
        },
        pagesInfo() {
            let currentPage = this.meta.current_page || 1; // Khi thằng đằng trước undefined thì nó lấy tạm giá trị 1
            let lastPage = this.meta.last_page || 1;

            return `Page ${currentPage} of ${lastPage}`;
        }
    },
    methods: {
        next() {
            if ( ! this.isLast) this.meta.current_page++;
            this.switchPage();
        },
        prev() {
            if ( ! this.isFirst) this.meta.current_page--;
            this.switchPage();
        },
        switchPage() {
            this.$router.push({
                name: 'questions',
                query: { page: this.meta.current_page }
            });
        }
    }
}
</script>