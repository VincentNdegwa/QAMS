<template>
    <div>
        <!-- Profile Card -->
        <div class="card mt-4 p-4">
            <h2>Your Profile</h2>
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label"
                        ><strong>Name:</strong></label
                    >
                    <input
                        type="text"
                        class="form-control border-0"
                        id="name"
                        v-model="user.name"
                        :disabled="!editProfile"
                    />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label"
                        ><strong>Email:</strong></label
                    >
                    <input
                        type="email"
                        class="form-control border-0"
                        id="email"
                        v-model="user.email"
                        :disabled="!editProfile"
                    />
                </div>
                <div class="mb-3 d-flex gap-3">
                    <button
                        v-if="!editProfile"
                        @click.prevent="openEditForm"
                        class="btn btn-secondary text-light"
                    >
                        Edit
                    </button>
                    <button
                        v-else
                        @click.prevent="cancelEditForm"
                        class="btn btn-danger text-light"
                    >
                        Cancel
                    </button>
                    <button
                        v-if="editProfile"
                        @click.prevent="updateEditForm"
                        class="btn btn-primary text-light"
                    >
                        Update
                    </button>
                </div>
            </form>
        </div>

        <!-- Password Card -->
        <div class="card mt-4 p-4">
            <h2>Update Password</h2>
            <form>
                <div class="mb-3 password-holder position-relative">
                    <label for="current_pass" class="form-label"
                        ><strong>Current Password:</strong></label
                    >
                    <input
                        class="form-control border-0"
                        id="current_pass"
                        v-model="password.current"
                        :type="showCurrentPassword ? 'text' : 'password'"
                    />
                    <i
                        @click="toggleCurrentPasswordVisibility"
                        :class="
                            showCurrentPassword
                                ? 'bi bi-eye-fill'
                                : 'bi bi-eye-slash-fill'
                        "
                        class="eye-icon position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer"
                    ></i>
                </div>
                <div class="mb-3 password-holder position-relative">
                    <label for="new_pass" class="form-label"
                        ><strong>New Password:</strong></label
                    >
                    <input
                        class="form-control border-0"
                        id="new_pass"
                        v-model="password.new"
                        :type="showNewPassword ? 'text' : 'password'"
                    />
                    <i
                        @click="toggleNewPasswordVisibility"
                        :class="
                            showNewPassword
                                ? 'bi bi-eye-fill'
                                : 'bi bi-eye-slash-fill'
                        "
                        class="eye-icon position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer"
                    ></i>
                </div>
                <div class="mb-3 password-holder position-relative">
                    <label for="confirm_pass" class="form-label"
                        ><strong>Confirm Password:</strong></label
                    >
                    <input
                        class="form-control border-0"
                        id="confirm_pass"
                        v-model="password.confirm"
                        :type="showConfirmPassword ? 'text' : 'password'"
                    />
                    <i
                        @click="toggleConfirmPasswordVisibility"
                        :class="
                            showConfirmPassword
                                ? 'bi bi-eye-fill'
                                : 'bi bi-eye-slash-fill'
                        "
                        class="eye-icon position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer"
                    ></i>
                </div>
                <div class="mb-3 d-flex gap-3">
                    <button
                        v-if="editPassword"
                        @click.prevent="updatePasswordForm"
                        class="btn btn-secondary text-light"
                    >
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        user: Object,
    },
    data() {
        return {
            editProfile: false,
            editPassword: true,
            showCurrentPassword: false,
            showNewPassword: false,
            showConfirmPassword: false,
            password: {
                current: "",
                new: "",
                confirm: "",
            },
        };
    },
    methods: {
        openEditForm() {
            this.editProfile = true;
        },
        cancelEditForm() {
            this.editProfile = false;
        },
        updateEditForm() {
            // Handle profile update logic here
            this.editProfile = false;
        },
        updatePasswordForm() {
            // Handle password update logic here
        },
        toggleCurrentPasswordVisibility() {
            this.showCurrentPassword = !this.showCurrentPassword;
        },
        toggleNewPasswordVisibility() {
            this.showNewPassword = !this.showNewPassword;
        },
        toggleConfirmPasswordVisibility() {
            this.showConfirmPassword = !this.showConfirmPassword;
        },
    },
};
</script>

<style scoped>
.card {
    background-color: var(--white);
    border-radius: 10px;
    max-height: max-content !important;
    height: max-content !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.form-control {
    outline: none !important;
}
.eye-icon {
    cursor: pointer;
}
.password-holder{
    & > i{
        margin-top: 15px !important;
        font-size: 20px;
    }
}
</style>
