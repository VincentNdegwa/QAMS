<script>
import { Head, router } from "@inertiajs/vue3";
export default {
    data() {
        return {
            nav: false,
            isDarkMode: false,
            user: {},
        };
    },
    methods: {
        logout() {
            router.post(route("logout"));
        },
        openNav() {
            this.nav = !this.nav;
            const navBar = document.querySelector(".nav_bar");
            navBar.classList.toggle("open");
        },
        toggleTheme() {
            this.isDarkMode = !this.isDarkMode;
        },
    },
    mounted() {
        let userData = window.localStorage.getItem("user");
        this.user = JSON.parse(userData);
    },
    components: {
        Head,
    },
};
</script>

<template>
    <nav class="nav_holder bg-dark position-sticky top-0">
        <div class="nav_bar">
            <div class="col d-flex flex-column align-items-center">
                <!-- Profile Picture -->
                <img
                    src="/images/testing.png"
                    alt="Profile Picture"
                    class="rounded-circle my-3"
                    style="width: 80px; height: 80px"
                />

                <!-- User Name -->
                <div class="text-primary mb-4">{{ user.name }}</div>

                <!-- Navigation Sections -->
                <nav class="nav">
                    <a
                        class="nav-link text-secondary w-100 mt-3"
                        href="/dashboard"
                    >
                        <i class="bi bi-house-door-fill text-primary me-2"></i>
                        Dashboard
                    </a>

                    <a
                        class="nav-link text-secondary w-100 mt-3"
                        href="/organisation"
                    >
                        <i class="bi bi-building-fill text-primary me-2"></i>
                        Organisation
                    </a>
                    <a class="nav-link text-secondary w-100 mt-3" href="#">
                        <i
                            class="bi bi-person-badge-fill text-primary me-2"
                        ></i>
                        Profile
                    </a>
                    <!-- <a
                        @click="toggleTheme"
                        class="nav-link text-secondary w-100 mt-3"
                    >
                        Dark Mode
                    </a> -->
                    <a
                        @click="logout"
                        class="nav-link text-secondary w-100 mt-3"
                    >
                        <i class="bi bi-box-arrow-left text-primary me-2"></i>
                        Logout
                    </a>
                </nav>
            </div>
        </div>

        <div
            class="d-md-none position-fixed start-0 align-items-center text-primary bg-dark medium_nav"
        >
            <div class="ms-auto text-end">
                <i @click="openNav" class="bi bi-list h1"></i>
            </div>
        </div>
    </nav>
</template>

<style>
.nav_bar {
    top: 0;
    height: 100vh !important;
    width: var(--nav_size) !important;
    box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.2);
    /* background: rgba(0, 0, 0, 0.4) !important; */
}

.medium_nav {
    height: var(--medimu_nav_height);
    top: 0;
    z-index: 10000 !important;
}

.nav-link {
    cursor: pointer;
}

.nav-link:hover {
    background-color: var(--bs-dark) !important;
}

.nav_holder {
    z-index: 1000;
    width: var(--nav_size);
    position: fixed !important;
}

@media (max-width: 768px) {
    .nav_bar {
        z-index: 10;
        display: none;
        transform: translateX(800px);
    }

    .medium_nav {
        width: 100%;
        box-shadow: 2px 3px 20px rgba(0, 0, 0, 0.5);
    }

    .nav_bar.open {
        position: sticky;
        top: 0;
        left: 0;
        border: 0 !important;
        display: block;
        width: 90% !important;
        background: var(--bs-dark) !important;
        transform: translateX(0);
    }

    .nav_holder {
        position: fixed !important;
        top: 0;
        width: 100% !important;
    }
}
</style>
