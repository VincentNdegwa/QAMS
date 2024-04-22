<script>
import { Head, router } from '@inertiajs/vue3';
import OrganisationForm from "./OrganisationForm.vue"
import OrganisationCards from "./OrganisationCards.vue"
import OrganisationAddUserForm from "./OrganisationAddUserForm.vue"

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
        Head,
        OrganisationForm,
        OrganisationCards,
        OrganisationAddUserForm
    }
}
</script>

<template>
    <div>
        <div class="d-flex align-items-end justify-content-end  mt-5 w-100">
            <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#form_org_modal">
                <i class="bi bi-plus-lg"></i>
                Create Organisation
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 mt-1">
                <form class="input-group">
                    <input type="text" class="form-control bg-secondary text-light border-0" placeholder="Search by organisation name">
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
                <OrganisationCards />
            </div>
        </div>

        <div class="modal fade" id="form_org_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <OrganisationForm />
        </div>
        <div class="modal fade" id="form_add_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <OrganisationAddUserForm />
        </div>
    </div>
</template>