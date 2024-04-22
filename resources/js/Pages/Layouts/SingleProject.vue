<script>
import { Head, router } from '@inertiajs/vue3';
import SideNav from "../components/SideNav.vue"
import ProjectNavs from '../components/SingleProjectComponents/ProjectNavs.vue';

export default {
    data() {
        return {

        }
    },
    methods: {

    },
    components: {
        SideNav,
        Head,
        ProjectNavs,
        

    }
}
</script>

<template>

    <Head title="Project" />
    <section class="container dash_container">
        <SideNav />
        <div class="main_content pd-0 p-md-2 mt-0">
            <ProjectNavs />
            <slot></slot>
        </div>

    </section>
</template>

<style>
.org_item,
.card {
    background-color: var(--bs-dark) !important;
    box-shadow: 3px 4px 20px rgba(0, 0, 0, 0.5);
    height: 22rem !important;
}

.pointer {
    cursor: pointer;
}
</style>
