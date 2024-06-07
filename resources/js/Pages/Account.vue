<template>
    <MainLayout name="Account">
        <div class="container mt-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-dark">
                <div class="navbar-collapse" id="navbarNav">
                    <div
                        class="text-primary d-flex flex-row gap-3 list-unstyled"
                    >
                        <li
                            class="bg-primary rounded-2 p-2"
                            @click="showSection('profile')"
                        >
                            <a
                                class="text-dark bg-primary rounded-2 p-2 text-decoration-none pointer"
                                >Profile</a
                            >
                        </li>
                        <li
                            class="bg-primary rounded-2 p-2 pointer"
                            @click="showSection('invitations')"
                        >
                            <a
                                class="text-dark bg-primary rounded-2 p-2 text-decoration-none"
                                >Invitations</a
                            >
                        </li>
                    </div>
                </div>
            </nav>

            <ProfileSection v-if="currentSection === 'profile'" :user="user" />
            <InvitationsSection
                v-if="currentSection === 'invitations'"
                :invitations="invitations"
                :selectedInvite="selectedInvite"
                :user_id ="user_id"
                @viewOptions="viewOptions"
            />
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "./Layouts/MainLayout.vue";
import ProfileSection from "./components/AccountComponents/ProfileSection.vue";
import InvitationsSection from "./components/AccountComponents/InvitationsSection.vue";
import { data } from "autoprefixer";

export default {
    props:{
        invitations:{
            type:Object,
            default: [],
        }, 
        user_id: {
            type: Number,
            required:true
        }
    },
    components: {
        MainLayout,
        ProfileSection,
        InvitationsSection,
    },
    data() {
        return {
            currentSection: "profile",
            user: {
                name: "John Doe",
                email: "john.doe@example.com",
            },selectedInvite:{}
        };
    },
    methods: {
        showSection(section) {
            this.currentSection = section;
        },
        viewOptions(id) {
            const invitation = this.invitations?.data.find(
                (invite) => invite.id === id
            );
            // console.log(invitation);
            // if (invitation && invitation.status === "open") {
            //     invitation.status = "closed";
            // }
        },
        
    },mounted(){
        //console.log(this.invitations);
    }
};
</script>

<style>
.navbar {
    background-color: var(--bright-blue);
}

.nav-link {
    color: var(--white) !important;
}
</style>
