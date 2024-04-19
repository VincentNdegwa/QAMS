<template>
    <div class="container container-section">
        <div class="row d-flex align-items-center">
            <div class="col image_holder align-items-center d-md-flex d-none ">
                <img src="images/testing.png" alt="">
            </div>
            <div class="col d-flex align-items-center text-primary">
                <div class="form_holder w-100 h-100">
                    <h4 class="card-title text-center mb-5">Login</h4>
                    <form @submit.prevent="register">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control form-control-lg" id="name" v-model="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control form-control-lg" id="email" v-model="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" v-model="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg">Register</button>

                        <div class="row mt-3">
                            <div class="col-6">
                                <a href="/login" class="p text-decoration-none text-light">You have an account?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.container-section,
.container-section>div {
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
export default {
    data() {
        return {
            name: '',
            email: '',
            password: ''
        };
    },
    methods: {
        register() {
            // Handle registration logic here
            console.log('Registration form submitted');
        }
    }
};
</script>
