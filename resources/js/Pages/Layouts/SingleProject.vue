<script>
import ProjectNavs from '../components/SingleProjectComponents/ProjectNavs.vue';
import MainLayout from './MainLayout.vue';

export default {
    data() {
        return {

        }
    },
    methods: {

    },
    components: {
        ProjectNavs,
        MainLayout


    }
}
</script>

<template>

    <MainLayout name="Project" >
        <ProjectNavs />
        <slot></slot>
    </MainLayout>
</template>

<style>

</style>
