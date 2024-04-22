<script>
import { Head, router } from '@inertiajs/vue3';
import SideNav from "./components/SideNav.vue"
import ProjectCard from "./components/ProjectComponents/ProjectCard.vue"
import ProjectForm from "./components/ProjectComponents/ProjectForm.vue"
import MainLayout from "./Layouts/MainLayout.vue"
export default {
    data() {
        return {
            nav: false,

        }
    },
    methods: {

    },
    components: {
        SideNav,
        Head,
        ProjectCard,
        ProjectForm,
        MainLayout
    }
}
</script>

<template>

    <MainLayout name="Project">
        <div class="pd-0">
            <div class="d-flex align-items-end justify-content-end  mt-5 w-100">
                <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#form_add_project">
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
                <div class="col-12 col-md-6 mt-1">
                    <select class="form-select bg-secondary text-light border-0">
                        <option value="">Filter by...</option>
                        <option value="option1">Option 1</option>
                        <option value="option2">Option 2</option>
                        <option value="option3">Option 3</option>
                    </select>
                </div>
            </div>


            <div class="row mt-5">
                <div class="col-12 col-md-6 col-lg-4 org_item">
                    <div class="card">
                        <div class="card-body p-4">
                            <img src="/images/project.png" class="w-100 h-75" alt="">
                            <div class="text-center text-primary" style="cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#form_add_project"><i class="bi bi-plus-lg"></i> Add Project</div>
                        </div>
                    </div>
                </div>

                <ProjectCard />
            </div>
            <div class="modal fade" id="form_add_project" tabindex="-1" aria-labelledby="form_add_project_label"
                aria-hidden="true">
                <ProjectForm />
            </div>
        </div>
    </MainLayout>


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
