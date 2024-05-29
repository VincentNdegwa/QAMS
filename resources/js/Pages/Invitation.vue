<template>
    <Head title="Invitation" />
    <div class="container mt-5 text-white">
        <div v-if="error" class="card text-white bg-gradient">
            <div class="card-body">
                <div class="alert alert-danger" role="alert">
                    {{ message }}
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <img
                        src="/images/sad-face.png"
                        class="sad-image align-items-center"
                        alt="sad face"
                    />
                </div>
            </div>
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
                        <strong>{{ data.timeDifference }}</strong>
                    </p>
                </div>
                <div class="d-flex gap-3 justify-content-center">
                    <button
                        @click="handleResponse(true)"
                        class="btn btn-green btn-lg mr-3"
                    >
                        Open Invitation
                    </button>
                    <button
                        @click="handleResponse(false)"
                        class="btn btn-danger btn-lg"
                    >
                        Cancel Invitation
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
import { Head, router } from "@inertiajs/vue3";

export default {
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
    components: {
        Head,
    },
    methods: {
        async handleResponse(accept) {
            if (this.data && !this.error) {
                let requestData = {
                    invited_user_id: this.data.user_id,
                    company_id: this.data.company_id,
                    status: accept,
                    role: "dev",
                    company_hash: this.data.company_hash,
                };

                try {
                    let response = await axios.post(
                        "/api/invite/enroll",
                        requestData
                    );

                    if (response.data.error) {
                        alert(response.data.message);
                    } else {
                        if (accept) {
                            alert(
                                "You have successfully joined the organization."
                            );
                            router.visit(
                                `/organisation/${this.data.company_id}/project`
                            );
                        } else {
                            alert(
                                "You have successfully cancelled the invitation."
                            );
                            router.visit("/");
                        }
                    }
                } catch (error) {
                    console.error(error);
                    alert("An error occurred. Please try again.");
                }
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
    mounted() {
        console.log(this.data);
    },
};
</script>

<style scoped>
body {
    background-color: var(--bs-dark);
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

.btn-danger {
    border: none;
}

.alert-danger {
    background-color: var(--bs-danger);
    border: none;
    color: var(--bs-light);
}

.card-footer {
    background-color: var(--bs-secondary);
}
.sad-image {
    width: 100%;
    height: 100% !important;
    max-width: 200px !important;
    max-height: 200px !important;
}
</style>
