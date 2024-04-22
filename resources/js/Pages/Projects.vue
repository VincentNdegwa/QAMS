<script>
import { Head, router } from '@inertiajs/vue3';
import SideNav from "./components/SideNav.vue"
import ProjectCard from "./components/ProjectComponents/ProjectCard.vue"

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
        ProjectCard
    }
}
</script>

<template>

    <Head title="Project" />
    <section class="container dash_container">
        <SideNav />
        <div class="main_content pd-0 p-md-2 mt-0">
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
                            <img src="/images/team.png" class="w-100 h-75" alt="">
                            <div class="text-center text-primary" style="cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#form_add_project"><i class="bi bi-plus-lg"></i> Add Project</div>
                        </div>
                    </div>
                </div>

                <ProjectCard />
            </div>
            <div class="modal fade" id="form_add_project" tabindex="-1" aria-labelledby="form_add_project_label"
                aria-hidden="true">
                <!-- Insert your project form component here -->
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-primary">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Project
                            </h5>
                            <button type="button" class="btn-close bg-dark text-primary" data-bs-dismiss="modal"
                                aria-label="Close"><i class="bi bi-x-lg"></i></button>
                        </div>
                        <div class="modal-body">
                            <form action="">
                                <div class="mb-3">
                                    <label for="organizationName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="organizationName" value="project name"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="organizationName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="organizationName" value="project name"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="organizationName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="organizationName" value="project name"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="organizationName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="organizationName" value="project name"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
