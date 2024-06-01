<template>
    <H1>{{ message }}</H1>
    <div class="d-flex align-items-center justify-content-center">
        <img
            src="/images/sad-face.png"
            class="sad-image align-items-center"
            alt="sad face"
        />
    </div>
</template>
<script>
export default {
    props: {
        message: {
            type: String,
            default: "",
        },
    },
};
</script>
<style>
.sad-image {
    width: 100%;
    height: 100% !important;
    max-width: 200px !important;
    max-height: 200px !important;
}
</style>
