<script>
import { Head, router } from "@inertiajs/vue3";
import SideNav from "./components/SideNav.vue";
import CircularProgress from "./components/DashComponents/CircularProgress.vue";
import TopMetrics from "./components/DashComponents/TopMetrics.vue";
import ProjectGraphs from "./components/DashComponents/ProjectGraphs.vue";
import ActivityFeed from "./components/DashComponents/ActivityFeed.vue";
import MainLayout from "./Layouts/MainLayout.vue";

export default {
    props: {
        Data: {
            type: Object,
        },
    },
    data() {
        return {
            nav: false,
        };
    },
    methods: {},
    components: {
        Head,
        SideNav,
        CircularProgress,
        TopMetrics,
        ProjectGraphs,
        ActivityFeed,
        MainLayout,
    },
    mounted() {
        window.localStorage.clear("user");
        window.localStorage.setItem("user", JSON.stringify(this.Data?.user));

        console.log(this.Data);
    },
};
</script>

<template>
    <MainLayout name="Dashboard">
        <div class="pd-0">
            <div class="row">
                <TopMetrics
                    name="Organisation"
                    :count="Data?.organisationCount"
                    description="A team of colleagues"
                />
                <TopMetrics
                    name="Projects"
                    :count="Data?.projectCount"
                    description="Manage your projects"
                />
                <TopMetrics
                    name="Tests"
                    :count="Data?.testCount"
                    description="Run your tests"
                />
                <TopMetrics
                    name="Issues"
                    :count="Data?.issueCount"
                    description="Track your issues"
                />
            </div>

            <div class="row">
                <ProjectGraphs
                    :testcaseProject="Data?.testcaseProject"
                    :projectOrganisation="Data?.projectOrganisation"
                />
            </div>
            <div class="row">
                <ActivityFeed :activities="Data?.activities" />
            </div>
        </div>
    </MainLayout>
</template>

<style></style>
