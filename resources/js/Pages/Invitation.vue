<template>
    <div class="container mt-5 text-white">
        <div v-if="error" class="alert alert-danger" role="alert">
            {{ message }}
        </div>
        <div v-else class="card shadow-lg rounded bg-dark text-white">
            <div class="card-header text-center bg-primary text-white py-4">
                <h2 class="card-title mb-0">You're Invited!</h2>
            </div>
            <div class="card-body p-5">
                <p class="lead text-center">
                    You have been invited to join the organization
                    <strong class="text-yellow">{{ data.company.name }}</strong
                    >.
                </p>
                <div class="text-center my-4">
                    <p class="mb-2">
                        Invitation sent by:
                        <strong>{{ data.user.name }}</strong>
                    </p>
                    <p>
                        Expires on:
                        <strong>{{ formatDate(data.expiration_date) }}</strong>
                    </p>
                </div>
                <div class="d-flex justify-content-center">
                    <button
                        @click="openOrganization"
                        class="btn btn-green btn-lg"
                    >
                        Open Invitation
                    </button>
                </div>
            </div>
            <div class="card-footer text-muted text-right bg-secondary">
                <small>Invitation ID: {{ data.id }}</small>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "InvitationResponseComponent",
    props: {
        error: {
            type: Boolean,
            required: true,
        },
        message: {
            type: String,
            required: true,
        },
        data: {
            type: Object,
            required: false,
        },
    },
    methods: {
        openOrganization() {
            if (this.data && this.data.company_hash) {
                window.location.href = `${process.env.VUE_APP_BASE_URL}/organization/${this.data.company_hash}`;
            } else {
                alert("Invalid invitation data.");
            }
        },
        formatDate(dateString) {
            const options = {
                year: "numeric",
                month: "long",
                day: "numeric",
                hour: "2-digit",
                minute: "2-digit",
            };
            return new Date(dateString).toLocaleDateString(undefined, options);
        },
    },
};
</script>

<style scoped>
body {
    background-color: var(--bs-dark); /* Dark background color */
}

.card {
    border: none;
}

.card-header {
    background-color: var(--bs-primary);
}

.text-green {
    color: var(--bs-green);
}

.text-yellow {
    color: var(--bs-yellow);
}

.btn-green {
    background-color: var(--bs-green);
    border: none;
    color: var(--bs-dark);
    border: 1px solid var(--bs-green) !important;
}

.btn-green:hover {
    background-color: darken(var(--bs-green), 10%);
    color: var(--bs-light) !important;
    border: 1px solid var(--bs-green) !important;
}

.alert-danger {
    background-color: var(--bs-danger);
    border: none;
    color: var(--bs-light);
}

.card-footer {
    background-color: var(--bs-secondary);
}
</style>
