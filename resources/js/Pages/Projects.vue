<script>
import { Head, router } from '@inertiajs/vue3';
import SideNav from "./components/SideNav.vue"
import ProjectCard from "./components/ProjectComponents/ProjectCard.vue"
import ProjectForm from "./components/ProjectComponents/ProjectForm.vue"
import MainLayout from "./Layouts/MainLayout.vue"
export default {
    props: {
        projects: {
            type: Array
        }, org_id: {
            type: String
        }, user_id: {
            type: Number
        }
    },
    data() {
        return {
            nav: false,
            overlay: {
                open: false,
            }

        }
    },
    methods: {
        openOverlay() {
            this.overlay.open = !this.overlay.open
        },
        updateData(data) {
            this.projects.push(data)
        }
    },
    components: {
        SideNav,
        Head,
        ProjectCard,
        ProjectForm,
        MainLayout
    }, mounted() {
        // console.log(this.user_id)
    }
}
</script>

<template>

    <MainLayout name="Project">
        <div class="pd-0">
            <div class="d-flex align-items-end justify-content-end  mt-5 w-100">
                <div class="btn btn-primary" @click="openOverlay">
                    <i class="bi bi-plus-lg"></i>
                    Add New Project
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 mt-1">
                    <form class="input-group">
                        <input type="text" class="form-control bg-secondary text-light border-0"
                            placeholder="Search by project name">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
             
            </div>


            <div class="row mt-5">
                <div class="col-12 col-md-6 col-lg-4 org_item">
                    <div class="card">
                        <div class="card-body p-4">
                            <img src="/images/project.png" class="w-100 h-75" alt="">
                            <div class="text-center text-primary" style="cursor: pointer;" @click="openOverlay"><i
                                    class="bi bi-plus-lg"></i>
                                Add Project</div>
                        </div>
                    </div>
                </div>

                <ProjectCard :projects="projects" />
            </div>
            <div :class="{ 'overlay': !overlay.open, 'overlay open': overlay.open }"
                aria-labelledby="form_add_project_label" aria-hidden="true">
                <ProjectForm @close0verlay="openOverlay" :org_id="org_id" @updateData="updateData" :user_id="user_id" />
            </div>
        </div>
    </MainLayout>


</template>

<style>
@import url("../../css/app.css");

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