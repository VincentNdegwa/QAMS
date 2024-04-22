<template>
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-primary">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Organisation</h5>
                <button type="button" class="btn-close bg-dark text-primary" data-bs-dismiss="modal"
                    aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="submitOrganizationForm">
                    <div class="mb-3">
                        <label for="organizationName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="organizationName" v-model="organizationForm.name"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="userId" class="form-label">User ID</label>
                        <input type="text" class="form-control" id="userId" v-model="organizationForm.user_id" readonly required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>

export default {

    data() {
        return {
            organizationForm: {
                name: '',
                user_id: '3'
            }
        }
    }, methods: {
        submitOrganizationForm() {
            
        }
    }
}</script>