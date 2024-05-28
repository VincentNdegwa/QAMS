<template>
    <Head title="Register" />
    <div class="container container-section">
        <div class="row d-flex align-items-center">
            <div class="col image_holder align-items-center d-md-flex d-none">
                <img src="images/testing.png" alt="" />
            </div>
            <div class="col d-flex align-items-center text-primary">
                <div class="form_holder w-100 h-100">
                    <h4 class="card-title text-center mb-5">Register</h4>
                    <ul
                        v-if="Object.keys(form.errors).length > 0"
                        class="alert alert-danger"
                    >
                        <li v-for="(error, key) in form.errors" :key="key">
                            {{ error }}
                        </li>
                    </ul>
                    <form @submit.prevent="register">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                id="name"
                                v-model="form.name"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"
                                >Email address</label
                            >
                            <input
                                type="email"
                                class="form-control form-control-lg"
                                id="email"
                                v-model="form.email"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"
                                >Password</label
                            >
                            <input
                                type="password"
                                class="form-control form-control-lg"
                                id="password"
                                v-model="form.password"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label
                                for="password_confirmation"
                                class="form-label"
                                >Password Confirm</label
                            >
                            <input
                                type="password"
                                class="form-control form-control-lg"
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                required
                            />
                        </div>
                        <button
                            type="submit"
                            class="btn btn-primary w-100 btn-lg"
                            :disabled="form.processing"
                        >
                            Register
                        </button>

                        <div class="row mt-3">
                            <div class="col-6">
                                <a
                                    href="/login"
                                    class="p text-decoration-none text-light"
                                    >You have an account?</a
                                >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.container-section,
.container-section > div {
    height: 100vh;
}

.image_holder {
    width: 100%;
    height: 100%;

    & img {
        object-fit: cover;
        width: 90%;
    }
}
</style>

<script>
import { Head, useForm } from "@inertiajs/vue3";

export default {
    components: {
        Head,
    },
    data() {
        return {
            form: useForm({
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
            }),
        };
    },
    methods: {
        register() {
            this.form.post(route("register"), {
                onFinish: () =>
                    this.form.reset("password", "password_confirmation"),
            });
        },
    },
};
</script>
