<template>
    <div class="card">
        <div class="card-body">
            <a
                :href="getUrl()"
                class="card-title text-secondary text-center text-decoration-none h5"
                >{{ organisation.name }}</a
            >
            <div class="row mt-4">
                <small class="card-text text-secondary"
                    >Created:
                    {{
                        new Date(organisation.created_at).toLocaleDateString()
                    }}</small
                >
                <small class="card-text text-secondary"
                    >Creator: {{ organisation.created_by.users.name }}</small
                >
            </div>
            <div class="d-flex justify-content-between mt-5">
                <div class="text-center row text-light">
                    <div class="col-12">Projects</div>
                    <span class="col-12">{{ organisation.project_count }}</span>
                </div>
                <div class="text-center row text-light">
                    <div class="col-12">Test Cases</div>
                    <span class="col-12">{{
                        organisation.test_case_count
                    }}</span>
                </div>
                <div class="text-center row text-light">
                    <div class="col-12">Issues</div>
                    <span class="col-12">{{ organisation.issues_count }}</span>
                </div>
            </div>
        </div>
        <div class="card-footer border-top border-secondary">
            <div class="row">
                <div
                    data-bs-toggle="modal"
                    data-bs-target="#form_add_user"
                    class="col-5 btn btn-primary text-dark"
                >
                    <i class="bi bi-person-add"></i> Add User
                </div>

                <div
                    class="col-7 d-flex justify-content-end align-items-center"
                >
                    <div class="d-flex align-items-center">
                        <i
                            @click="editOrganisation(organisation)"
                            class="bi bi-pencil me-2 h5 pointer text-primary"
                            data-bs-toggle="popover"
                            title="Edit"
                            data-bs-content="Click to edit this item"
                            data-bs-trigger="hover"
                        >
                        </i>
                        <i
                            class="bi bi-trash-fill me-2 h5 pointer text-primary"
                            data-bs-toggle="popover"
                            title="Delete"
                            data-bs-content="Click to delete this item"
                            data-bs-trigger="hover"
                        >
                        </i>
                        <a :href="getUrl()">
                            <i
                                class="bi bi-arrow-right-circle text-primary pointer h5"
                                data-bs-toggle="popover"
                                title="View"
                                data-bs-content="Click to view this organisation"
                                data-bs-trigger="hover"
                            ></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        organisation: {
            type: Object,
        },
    },
    methods: {
        getUrl() {
            return "organisation/" + this.organisation.id + "/project";
        },
        editOrganisation(data) {
            this.$emit("updateOrganisation", data);
        },
    },
};
</script>
