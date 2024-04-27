<template>
    <SingleProject>

    </SingleProject>
</template>
<script>
import SingleProject from "./Layouts/SingleProject.vue"
export default {
    props: {
        organisation_id: {
            type: Number
        },
        project_id: {
            type: Number
        },
        modules: {
            type: Array
        }
    },
    components: {
        SingleProject
    }, mounted() {
        console.log(this.organisation_id, this.project_id, this.modules);
    }
}
</script>