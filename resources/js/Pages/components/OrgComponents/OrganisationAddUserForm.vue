<template>
    <div>
        <Overlay :open="openUserForm" @closeOverlay="toggleOverlay">
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
                        v-model="organizationForm.company_id"
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
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </Overlay>
    </div>
</template>
<script>
import axios from "axios";
import Overlay from "@/Pages/Layouts/Overlay.vue";

export default {
    props: {
        user_id: {
            type: Number,
        },
        organisation_id: {
            type: String,
            required: true,
        },
        openUserForm: {
            type: Boolean,
            default: false,
        },
    },
    components: {
        Overlay,
    },
    data() {
        return {
            organizationForm: {
                email: "",
                company_id: this.organisation_id,
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
            this.organizationForm.company_id = newVal;
        },
    },
    methods: {
        validateForm() {
            this.formErrors = null;
            const errors = {};

            if (!this.organizationForm.email) {
                errors.email = "Email is required.";
            } else if (!/\S+@\S+\.\S+/.test(this.organizationForm.email)) {
                errors.email = "Email is invalid.";
            }

            return Object.keys(errors).length === 0 ? null : errors;
        },
        async submitOrganizationForm() {
            this.formErrors = this.validateForm();

            if (this.formErrors) {
                return;
            }

            try {
                const response = await axios.post(
                    "/api/invite/add",
                    this.organizationForm
                );

                if (response.data.error) {
                    console.log(response.data.message);
                } else {
                    console.log("Success:", response.data);
                }
            } catch (error) {
                console.error("Request failed:", error);
            }
        },
        toggleOverlay() {
            this.$emit("toggleUserForm");
        },
    },
    mounted() {},
};
</script>
