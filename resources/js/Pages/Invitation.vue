<template>
    <div class="container mt-5 text-white">
        <div v-if="error" class="alert alert-danger" role="alert">
            {{ message }}
        </div>
        <div v-else class="card bg-secondary text-white">
            <div class="card-header bg-primary">
                <h2>Invitation</h2>
            </div>
            <div class="card-body">
                <p class="card-text">{{ message }}</p>
                <button @click="openOrganization" class="btn btn-success">
                    Open
                </button>
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
    },
};
</script>

<style>
body {
    background-color: #212529; /* Dark background color */
}
</style>
