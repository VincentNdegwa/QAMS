<script>
import { Head, router } from "@inertiajs/vue3";
import SideNav from "../components/SideNav.vue";

export default {
    props: {
        name: {
            type: String,
            default: "Laravel",
        },
    },
    data() {
        return {
            nav: false,
        };
    },
    methods: {},
    components: {
        SideNav,
        Head,
    },
    mounted() {},
};
</script>

<template>
    <Head :title="name" />
    <section class="container dash_container">
        <SideNav />
        <div class="main_content pd-0 p-md-2 mt-0">
            <slot></slot>
        </div>
    </section>
</template>

<style></style>
