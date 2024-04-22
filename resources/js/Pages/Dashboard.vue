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
                <TopMetrics name="Organisation" description="A team of colleagues" />
                <TopMetrics name="Projects" description="Manage your projects" />
                <TopMetrics name="Tests" description="Run your tests" />
                <TopMetrics name="Issues" description="Track your issues" />
            </div>

            <div class="row">
                <ProjectGraphs />
            </div>
            <div class="row mt-3">
                <div class="col-12 col-xl-6">
                    <div class="row d-flex ms-5 ms-md-0">
                        <div class="col-12 col-md-6">
                            <CircularProgress />
                        </div>
                        <div class="col-12 col-md-6">
                            <CircularProgress />
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-6 flex-column">
                    <div class="p text-center text-primary">Activity Feed</div>
                    <ActivityFeed />
                </div>
            </div>
        </div>

    </MainLayout>
</template>

<style></style>
