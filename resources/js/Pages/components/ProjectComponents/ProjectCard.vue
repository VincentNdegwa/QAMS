<template>
    <div class="col-12 col-md-6 col-lg-4 org_item mt-1 ">
        <div class="card">
            <div class="card-body text-secondary">
                <h5 class="card-title text-primary ">Project Name</h5>
                <p class="card-text mt-4 text-light">Organization: <span class="text-secondary">Organization Name</span>
                </p>
                <p class="card-text text-light">Created at: <span class="text-secondary">23rd May,2024</span></p>
                <!-- <p class="card-text text-light">Creator: <span class="text-secondary">John Doe</span></p> -->
                <p class="card-text text-light">Test Cases: <span class="text-secondary">200</span></p>
                <p class="card-text text-light">Issues: <span class="text-secondary">30</span></p>

                <!-- Add additional details as needed -->
            </div>
            <div class="card-footer border-top border-secondary">
                <div class="row">
                    <a href="/organisation/1/project/1" class="col-5 btn btn-primary text-dark">
                        <i class="bi bi-arrow-right-circle"></i> Open
                    </a>
                    <div class="col-7 d-flex justify-content-end align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-pencil me-2 h5 pointer text-primary" data-bs-toggle="popover" title="Edit"
                                data-bs-content="Click to edit this project" data-bs-trigger="hover"></i>
                            <i class="bi bi-trash-fill me-2 h5 pointer text-primary" data-bs-toggle="popover"
                                title="Delete" data-bs-content="Click to delete this project"
                                data-bs-trigger="hover"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    // Define props, methods, etc. if needed
};
</script>

<style>
/* Add your custom styles here */
.org_item .card {
    background-color: var(--bs-dark) !important;
    box-shadow: 3px 4px 20px rgba(0, 0, 0, 0.5);
    height: 22rem !important;
}

.org_item .pointer {
    cursor: pointer;
}
</style>
