<script>
import { Head, router } from '@inertiajs/vue3';
export default {
    data() {
        return {
            nav: false
        }
    },
    methods: {
        logout() {
            router.post(route("logout"))
        },
        openNav() {
            this.nav = !this.nav
            const navBar = document.querySelector('.nav_bar');
            navBar.classList.toggle('open');
        }
    }, components: {
        Head
    }
}
</script>

<template>

    <Head title="Dashboard" />
    <section class="container dash_container">
        <div class="row">
            <div class="position-sticky bg-black nav_bar">
                <div class="col d-flex flex-column align-items-center">
                    <!-- Profile Picture -->
                    <img src="images/testing.png" alt="Profile Picture" class="rounded-circle my-3"
                        style="width: 80px; height: 80px;">

                    <!-- User Name -->
                    <div class="text-primary mb-4">John Doe</div>

                    <!-- Navigation Sections -->
                    <nav class="nav">
                        <a class="nav-link text-secondary w-100 mt-3" href="#">
                            <i class="bi bi-house-door-fill text-primary  me-2"></i>
                            Dashboard
                        </a>

                        <a class="nav-link text-secondary w-100 mt-3" href="#">
                            <i class="bi bi-chat-left-fill text-primary  me-2"></i>
                            Inbox
                        </a>
                        <a class="nav-link text-secondary w-100 mt-3" href="#">
                            <i class="bi bi-clipboard-check text-primary  me-2"></i>
                            Sent
                        </a>
                        <a class="nav-link text-secondary w-100 mt-3" href="#">
                            <i class="bi bi-journal-album text-primary  me-2"></i>
                            Archive
                        </a>

                        <a class="nav-link text-secondary w-100 mt-3" href="#">
                            <i class="bi bi-gear-fill text-primary  me-2"></i>
                            Settings
                        </a>
                        <a class="nav-link text-secondary w-100 mt-3" href="#">
                            <i class="bi bi-person-badge-fill text-primary  me-2"></i>
                            Profile
                        </a>
                        <a @click="logout" class="nav-link text-secondary w-100 mt-3">
                            <i class="bi bi-box-arrow-left text-primary  me-2"></i>
                            Logout
                        </a>
                    </nav>
                </div>
            </div>

            <div class="col main_content ml-20">
                <div class="row d-md-none position-sticky align-items-center text-primary medium_nav">
                    <div class="ms-auto text-end">
                        <i @click="openNav" class="bi bi-list h2"></i>
                    </div>
                    menu
                </div>
            </div>
        </div>
    </section>
</template>

<style>
:root {
    --nav_size: 200px;
    transition: all ease-out 1s !important;
}

.dash_container {
    position: relative;
}

.nav_bar {
    top: 0;
    height: 100vh !important;
    width: var(--nav_size) !important;
    background: rgba(0, 0, 0, 0.4) !important;
}

.medium_nav {
    height: 2.5em;
    top: 0;
    z-index: 1000 !important;
}

.nav-link {
    cursor: pointer;
}

.nav-link:hover {
    background-color: var(--bs-dark) !important;
}

.main_content {
    height: max-content !important;
    margin-left: var(--nav_size);
}

@media (max-width: 768px) {
    .nav_bar {
        z-index: 10;
        display: none;
    }

    .main_content {
        margin-left: 0;
    }

    .nav_bar.open {
        display: block;
        width: 90% !important;
        background: rgba(0, 0, 0, 0.4) !important;
    }
}
</style>
