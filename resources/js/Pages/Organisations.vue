<script>
import { Head, router } from '@inertiajs/vue3';
import SideNav from "./components/SideNav.vue"
import OrganisationMain from "./components/OrgComponents/OrganisationMain.vue"
import MainLayout from "./Layouts/MainLayout.vue"



export default {
    props: {
        user_id: {
            type: Number,
            default: ""
        },
        organisations: {
            type: Array
        }
    },
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
        OrganisationMain,
        MainLayout

    }, mounted() {
        console.log(this.organisations);
    }
}
</script>

<template>

    <MainLayout name="Organisations">
        <OrganisationMain :user_id="user_id" :organisations="organisations" />
    </MainLayout>

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
