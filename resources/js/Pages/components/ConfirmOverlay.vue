<template>
    <OverLay :open="isOpen" @closeOverlay="cancel">
        <div class="bg-dark" v-if="isOpen">
            <div
                class="d-flex flex-column align-items-center justify-content-center"
            >
                <span class="text-center" v-html="message"></span>

                <img
                    class="w-25 h-25"
                    src="/images/question.png"
                    alt="question"
                />
            </div>
            <div class="d-flex flex-row justify-content-evenly">
                <button
                    class="btn btn-confirm btn-primary w-100 ms-1"
                    @click="confirm"
                >
                    Confirm
                </button>
                <button
                    class="btn btn-cancel btn-danger w-100 ms-1"
                    @click="cancel"
                >
                    Cancel
                </button>
            </div>
        </div>
    </OverLay>
</template>
<script>
import OverLay from "../Layouts/Overlay.vue";
export default {
    components: {
        OverLay,
    },
    data() {
        return {};
    },
    props: {
        message: {
            type: String,
            required: true,
        },
        openOverlay: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            isOpen: this.openOverlay,
        };
    },
    methods: {
        show() {
            this.isOpen = true;
        },
        confirm() {
            this.$emit("confirmed", true);
            this.hide();
        },
        cancel() {
            this.$emit("confirmed", false);
            this.hide();
        },
        hide() {
            this.isOpen = false;
        },
    },
};
</script>

<style>
.card-body > img {
    height: 200px !important;
    width: 200px;
}
</style>
