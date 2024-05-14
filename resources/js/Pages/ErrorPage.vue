<template>
    <H1>{{ message }}</H1>
</template>
<script>
export default {
    props: {
        message: {
            type: String,
            default: ""
        }
    }
}
</script>