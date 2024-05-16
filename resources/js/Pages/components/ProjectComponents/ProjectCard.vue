<template>
    <div
        class="col-12 col-md-6 col-lg-4 org_item mt-1"
        v-for="(item, index) in projects"
        :key="index"
    >
        <div class="card mt-1">
            <div class="card-body text-secondary">
                <h5 class="card-title text-primary text-capitalize">
                    {{ item.name }}
                </h5>
                <p class="card-text mt-4 text-light">
                    Organization:
                    <span class="text-secondary">{{ item.company.name }}</span>
                </p>
                <p class="card-text text-light">
                    Created at:
                    <span class="text-secondary">{{
                        new Date(item.created_at).toLocaleDateString()
                    }}</span>
                </p>
                <!-- <p class="card-text text-light">Creator: <span class="text-secondary">John Doe</span></p> -->
                <p class="card-text text-light">
                    Test Cases:
                    <span class="text-secondary">{{
                        item.test_cases_count
                    }}</span>
                </p>
                <p class="card-text text-light">
                    Issues:
                    <span class="text-secondary">{{ item.issues_count }}</span>
                </p>

                <!-- Add additional details as needed -->
            </div>
            <div class="card-footer border-top border-secondary">
                <div class="row">
                    <a
                        :href="getUrl(item)"
                        class="col-5 btn btn-primary text-dark"
                    >
                        <i class="bi bi-arrow-right-circle"></i> Open
                    </a>
                    <div
                        class="col-7 d-flex justify-content-end align-items-center"
                    >
                        <div class="d-flex align-items-center">
                            <i
                                class="bi bi-pencil me-2 h5 pointer text-primary"
                                data-bs-toggle="popover"
                                title="Edit"
                                data-bs-content="Click to edit this project"
                                data-bs-trigger="hover"
                            ></i>
                            <i
                                class="bi bi-trash-fill me-2 h5 pointer text-primary"
                                data-bs-toggle="popover"
                                title="Delete"
                                data-bs-content="Click to delete this project"
                                data-bs-trigger="hover"
                            ></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        projects: {
            type: Array,
        },
    },
    methods: {
        getUrl(item) {
            return `project/${item.id}/open`;
        },
    },
};
</script>

<style>
.org_item .card {
    background-color: var(--bs-dark) !important;
    box-shadow: 3px 4px 20px rgba(0, 0, 0, 0.5);
    height: 22rem !important;
}

.org_item .pointer {
    cursor: pointer;
}
</style>
