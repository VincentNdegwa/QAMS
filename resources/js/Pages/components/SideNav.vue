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


    <nav class="nav_holder">
        <div class="position-sticky top-0 nav_bar">
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

        <div class="d-md-none position-fixed start-0 align-items-center text-primary bg-dark medium_nav">
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
    background: rgba(0, 0, 0, 0.4) !important;
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
    width: min-content;
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
