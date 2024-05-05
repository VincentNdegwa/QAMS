<script>
import { Head, router } from '@inertiajs/vue3';
import SideNav from "./components/SideNav.vue"
import CircularProgress from "./components/DashComponents/CircularProgress.vue"
import TopMetrics from "./components/DashComponents/TopMetrics.vue"
import ProjectGraphs from "./components/DashComponents/ProjectGraphs.vue"
import ActivityFeed from "./components/DashComponents/ActivityFeed.vue"
import MainLayout from "./Layouts/MainLayout.vue"

export default {
    data() {
        return {
            nav: false,


        }
    },
    props: {
        data: {
            type: Object
        }
    },
    mounted() {
        console.log(this.data)
    },
    methods: {

    }, components: {
        Head,
        SideNav,
        CircularProgress,
        TopMetrics,
        ProjectGraphs,
        ActivityFeed,
        MainLayout
    }
}
</script>

<template>

    <MainLayout name="Dashboard">
        <div class="pd-0">
            <div class="row">
                <TopMetrics name="Organisation" :count="data.organisationCount" description="A team of colleagues" />
                <TopMetrics name="Projects" :count="data.projectCount" description="Manage your projects" />
                <TopMetrics name="Tests" :count="data.testCount" description="Run your tests" />
                <TopMetrics name="Issues" :count="data.issueCount" description="Track your issues" />
            </div>

            <div class="row">
                <ProjectGraphs :testcaseProject="data.testcaseProject"
                    :projectOrganisation="data.projectOrganisation" />
            </div>
            <div class="row">
                <ActivityFeed />
              
            </div>
        </div>

    </MainLayout>
</template>

<style></style>
