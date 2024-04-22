<script>
import { Head, router } from '@inertiajs/vue3';
import SideNav from "./components/SideNav.vue"
import OrganisationMain from "./components/OrgComponents/OrganisationMain.vue"


export default {
    data() {
        return {
            nav: false,

        }
    },
    methods: {
        submitOrganizationForm() {
            // Handle form submission here
        }
    },
    components: {
        SideNav,
        Head,
        OrganisationMain

    }
}
</script>

<template>

    <Head title="Organisations" />
    <section class="container dash_container">
        <SideNav />
        <div class="main_content pd-0 p-md-2">
            <OrganisationMain />
        </div>

    </section>
</template>

<style>
.org_item,
.card {
    background-color: var(--bs-dark) !important;
    box-shadow: 3px 4px 20px rgba(0, 0, 0, 0.5);
    height: 22rem !important;
}

.pointer {
    cursor: pointer;
}
</style>
