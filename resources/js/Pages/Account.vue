<template>
    <MainLayout name="Account">
        <div class="container mt-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-dark">
                <div class="navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav text-primary">
                        <li class="nav-item">
                            <a
                                class="nav-link text-white"
                                href="#"
                                @click="showSection('profile')"
                                >Profile</a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link text-white"
                                href="#"
                                @click="showSection('invitations')"
                                >Invitations</a
                            >
                        </li>
                    </ul>
                </div>
            </nav>

            <ProfileSection v-if="currentSection === 'profile'" :user="user" />
            <InvitationsSection
                v-if="currentSection === 'invitations'"
                :invitations="invitations"
                @update-status="updateStatus"
                @update-role="updateRole"
            />
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "./Layouts/MainLayout.vue";
import ProfileSection from "./components/AccountComponents/ProfileSection.vue";
import InvitationsSection from "./components/AccountComponents/InvitationsSection.vue";

export default {
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
            },
            invitations: [
                {
                    id: 1,
                    name: "Jane Smith",
                    status: "open",
                    company: "Example Corp",
                },
                {
                    id: 2,
                    name: "Emily Johnson",
                    status: "joined",
                    company: "Tech Inc",
                },
                {
                    id: 3,
                    name: "Michael Brown",
                    status: "closed",
                    company: "Global Solutions",
                },
            ],
        };
    },
    methods: {
        showSection(section) {
            this.currentSection = section;
        },
        updateStatus(id) {
            const invitation = this.invitations.find(
                (invite) => invite.id === id
            );
            if (invitation && invitation.status === "open") {
                invitation.status = "closed"; // Example status change
            }
        },
        updateRole(id) {
            const invitation = this.invitations.find(
                (invite) => invite.id === id
            );
            if (invitation && invitation.status === "joined") {
                // Logic to update role
            }
        },
    },
};
</script>

<style scoped>
.navbar {
    background-color: var(--bright-blue);
}

.nav-link {
    color: var(--white) !important;
}
</style>
