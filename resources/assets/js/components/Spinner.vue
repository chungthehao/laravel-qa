<template>
    <div class="spinner" :style="styleObj">
        <i class="fa fa-spinner fa-spin" :class="sizeClass"></i>
    </div>
</template>

<style scoped>
.spinner {
    color: #ddd;
    text-align: center;
}
</style>

<script>
export default {
    props: {
        small: {
            type: Boolean,
            default: false
        },
        minWidth: {
            type: Number,
            default: 100
        }
    },
    computed: {
        sizeClass() {
            return this.small ? 'fa-1x' : 'fa-3x';
        },
        styleObj() {
            return {
                minWidth: this.minWidth + 'px'
            }
        }
    }
}
</script>