<script>
import { Head, router } from "@inertiajs/vue3";
import OrganisationForm from "./OrganisationForm.vue";
import OrganisationCards from "./OrganisationCards.vue";
import OrganisationAddUserForm from "./OrganisationAddUserForm.vue";
import ConfirmOverlay from "../ConfirmOverlay.vue";
import axios from "axios";

export default {
    props: {
        user_id: {
            type: Number,
        },
        organisations: {
            type: Array,
        },
    },
    data() {
        return {
            nav: false,
            overlay: {
                show: false,
            },
            OrganisationToUpdate: {},
            organisationArray: this.organisations || [],
            organisationSearch: "",
            selectedOrganisation: "",
            openConfirm: false,
            confirmationMessage: "",
            clickedOrganisationId: "",
        };
    },
    methods: {
        updateData(data) {
            this.organisations.push(data);
        },
        openOverlay() {
            this.overlay.show = !this.overlay.show;
        },
        updateOrganisation(data) {
            this.OrganisationToUpdate = data;
            this.openOverlay();
        },
        updateData(data) {
            let id = data.id;
            let name = data.name;
            let item = this.organisationArray.find((item) => item.id === id);
            if (item) {
                item.name = name;
            } else {
                console.log(`Item with id ${id} not found`);
            }
        },
        handleSearch() {
            axios
                .post("/api/organisation/search", {
                    search: this.organisationSearch,
                    user_id: this.user_id,
                })
                .then((res) => {
                    if (!res.data.error) {
                        this.organisationArray = res.data.data;
                        // console.log(res.data.data);
                    } else {
                        alert(res.data.message);
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        deleteOrganisation(data) {
            this.openConfirm = true;
            this.confirmationMessage =
                "Are you sure you want to delete this organisation? <br> This action will delete all the data related to the organisation.";
            this.selectedOrganisation = data.id;
        },
        handleDelete(status) {
            this.openConfirm = false;
            if (status) {
                axios
                    .post("/api/organisation/delete", {
                        id: this.selectedOrganisation,
                        user_id: this.user_id,
                    })
                    .then((res) => {
                        if (!res.data.error) {
                            console.log(res.data);
                        } else {
                            alert(res.data.message);
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
        },
        inviteUser(id) {
            this.clickedOrganisationId = id;
        },
    },
    components: {
        Head,
        OrganisationForm,
        OrganisationCards,
        OrganisationAddUserForm,
        ConfirmOverlay,
    },
};
</script>

<template>
    <div>
        <div
            class="d-flex flex-column position-sticky top-0 bg-dark top-header"
        >
            <div class="d-flex align-items-end justify-content-end mt-5 w-100">
                <div @click="openOverlay" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i>
                    Create Organisation
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 mt-1">
                    <form class="input-group">
                        <input
                            type="text"
                            class="form-control bg-secondary text-light border-0"
                            placeholder="Search by organisation name"
                            v-model="organisationSearch"
                            @input="handleSearch"
                        />
                        <button class="btn btn-primary" type="submit">
                            Search
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row mt-3 ms-1">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body p-4">
                        <img src="images/team.png" class="w-100 h-75" alt="" />
                        <div
                            class="text-center text-primary"
                            style="cursor: pointer"
                            @click="openOverlay"
                        >
                            <i class="bi bi-plus-lg"></i> Add Project
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="col-12 col-md-6 col-lg-4 mt-3 mt-md-0"
                v-for="(item, index) in organisationArray"
                :key="index"
            >
                <OrganisationCards
                    :organisation="item"
                    @updateOrganisation="updateOrganisation"
                    @deleteOrganisation="deleteOrganisation"
                    @inviteUser="inviteUser"
                />
            </div>
        </div>

        <div
            :class="{ overlay: !overlay.show, 'overlay open': overlay.show }"
            id="form_org_modal"
        >
            <OrganisationForm
                :user_id="user_id"
                @new_org="updateData"
                @removeOverlay="openOverlay"
                :OrganisationToUpdate="OrganisationToUpdate"
                @updateData="updateData"
            />
        </div>
        <div
            class="modal fade"
            id="form_add_user"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <OrganisationAddUserForm
                :user_id="user_id"
                :organisation_id="clickedOrganisationId"
            />
        </div>
    </div>
    <ConfirmOverlay
        v-if="openConfirm"
        :openOverlay="openConfirm"
        :message="confirmationMessage"
        @confirmed="handleDelete"
    />
</template>

<style>
.top-header {
    z-index: 100 !important;
}
</style>
