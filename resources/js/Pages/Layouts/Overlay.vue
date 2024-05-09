<template>
    <div :class="{ 'overlay': !open, 'overlay open': open }" id="form_org_modal">
        <div class="overlay-dialog" :class="{ 'md': size == 'md', 'lg': size == 'lg', 'xlg': size == 'xlg' }">
            <div class="overlay-content bg-dark text-primary">
                <div class="overlay-header">
                    <h5 class="overlay-title" id="exampleModalLabel">{{ header }}</h5>
                    <button @click="removeOverlay" type="button" class="btn btn-danger text-light">
                        <i class="bi bi-x-lg"></i>
                        <small class="ms-2">Close</small>
                    </button>
                </div>
                <div class="overlay-body">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        header: {
            type: String,
            default: ""
        },
        open: {
            type: Boolean,
            default: false
        },
        size: {
            type: String,
            default: "md"
        }
    },
    data() {
        return {

        }
    },
    methods: {
        removeOverlay() {
            this.$emit("closeOverlay")
        }
    }
}
</script>