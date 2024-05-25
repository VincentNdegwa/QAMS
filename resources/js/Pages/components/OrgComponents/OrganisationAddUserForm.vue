<template>
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-primary">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="exampleModalLabel">Invite User</h5>
                <i
                    class="bi bi-file-excel h3 text-danger"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></i>
            </div>
            <div class="modal-body">
                <form @submit.prevent="submitOrganizationForm">
                    <div class="mb-3">
                        <label for="organizationName" class="form-label"
                            >Email</label
                        >
                        <input
                            type="email"
                            class="form-control"
                            id="organizationName"
                            placeholder="Enter invitee's email"
                            v-model="organizationForm.email"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label for="userId" class="form-label"
                            >Organisation Id</label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="userId"
                            v-model="organizationForm.organisation"
                            readonly
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label for="userId" class="form-label">User ID</label>
                        <input
                            type="text"
                            class="form-control"
                            id="userId"
                            v-model="organizationForm.user_id"
                            readonly
                            required
                        />
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    props: {
        user_id: {
            type: Number,
        },
        organisation_id: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            organizationForm: {
                email: "",
                organisation: this.organisation_id,
                user_id: this.user_id,
            },
            formErrors: null,
        };
    },
    watch: {
        user_id(newVal) {
            this.organizationForm.user_id = newVal;
        },
        organisation_id(newVal) {
            this.organizationForm.organisation = newVal;
        },
    },
    methods: {
        validateForm() {
            this.formErrors = null;
            const errors = {};
            
            if (!this.organizationForm.email) {
                errors.email = 'Email is required.';
            } else if (!/\S+@\S+\.\S+/.test(this.organizationForm.email)) {
                errors.email = 'Email is invalid.';
            }
            
            return Object.keys(errors).length === 0 ? null : errors;
        },
        async submitOrganizationForm() {
            this.formErrors = this.validateForm();
            
            if (this.formErrors) {
                return;
            }
            
            try {
                const response = await axios.post('/api/invite/add', this.organizationForm);
                
                if (response.data.error) {
                    // Handle error from the server
                    console.error('Error from server:', response.data.error);
                } else {
                    // Handle success
                    console.log('Success:', response.data);
                }
            } catch (error) {
                console.error('Request failed:', error);
            }
        }
    }
};
</script>


