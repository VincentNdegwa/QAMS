<script>
import { Head, router } from '@inertiajs/vue3';
import SideNav from "./components/SideNav.vue"
import OrganisationForm from "./components/DashComponents/OrganisationForm.vue"

export default {
    data() {
        return {
            nav: false,

        }
    },
    methods: {
        submitOrganizationForm() {
            // Handle form submission here
        }
    },
    components: {
        SideNav,
        Head,
        OrganisationForm
    }
}
</script>

<template>

    <Head title="Organisations" />
    <section class="container dash_container">
        <SideNav />
        <div class="main_content pd-0 p-md-2">
            <div class="d-flex align-items-end justify-content-end  mt-5 w-100">
                <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#form_org_modal">
                    <i class="bi bi-plus-lg"></i>
                    Create Organisation
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 mt-1">
                    <form class="input-group">
                        <input type="text" class="form-control bg-secondary text-light border-0"
                            placeholder="Search...">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
                <div class="col-12 col-md-6 mt-1">
                    <select class="form-select bg-secondary text-light border-0">
                        <option value="">Filter by...</option>
                        <option value="option1">Option 1</option>
                        <option value="option2">Option 2</option>
                        <option value="option3">Option 3</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
            </div>
            <div class="row mt-3 ms-1">
                <div class="col-12 col-md-6 col-lg-4 org_item ">
                    <div class="card">
                        <div class="card-body p-4">
                            <img src="images/team.png" class="w-100 h-75" alt="">
                            <div class="text-center text-primary" style="cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#form_org_modal"><i class="bi bi-plus-lg"></i> Add Project</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mt-3 mt-md-0 org_item">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-secondary text-center ">Organization Name</h5>
                            <div class="row mt-2">
                                <small class="card-text text-primary">Created: [Date]</small>
                                <small class="card-text text-primary">Creator: [Creator Name]</small>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <div class="text-center row text-light">
                                    <div class="col-12">
                                        Projects
                                    </div>
                                    <span class="col-12">2</span>
                                </div>
                                <div class="text-center row text-light">
                                    <div class="col-12">
                                        Test Cases
                                    </div>
                                    <span class="col-12">200</span>
                                </div>
                                <div class="text-center row text-light">
                                    <div class="col-12">
                                        Issues
                                    </div>
                                    <span class="col-12">30</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                              
                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <div class="modal fade" id="form_org_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <OrganisationForm />
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
</style>
