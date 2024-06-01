<template>
    <Head title="Login" />
    <div class="container container-section">
        <div class="row d-flex align-items-center">
            <div class="col image_holder align-items-center d-none d-md-flex">
                <img src="images/testing.png" alt="" />
            </div>
            <div class="col d-flex align-items-center text-primary">
                <div class="form_holder w-100 h-100">
                    <h4 class="card-title text-center mb-5">Login</h4>
                    <ul
                        v-if="Object.keys(errors).length > 0"
                        class="alert alert-danger"
                    >
                        <li v-for="(error, key) in errors" :key="key">
                            {{ error }}
                        </li>
                    </ul>
                    <form @submit.prevent="login">
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
                        <button
                            type="submit"
                            class="btn btn-primary w-100 btn-lg"
                        >
                            Login
                        </button>
                        <div class="row mt-3">
                            <div class="col-6">
                                <a
                                    href="/forgot-password"
                                    class="p text-decoration-none text-secondary"
                                    >Forgot password?</a
                                >
                            </div>
                            <div class="col-6">
                                <a
                                    href="/register"
                                    class="p text-decoration-none text-light"
                                    >Don't have an account?</a
                                >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, Link, useForm } from "@inertiajs/vue3";
export default {
    props: { errors: Object },
    data() {
        const form = useForm({
            email: "",
            password: "",
        });
        return {
            form,
        };
    },
    methods: {
        login() {
            this.form.post(route("login"));
        },
    },
    components: {
        Head,
    },
};
</script>

<style>
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
