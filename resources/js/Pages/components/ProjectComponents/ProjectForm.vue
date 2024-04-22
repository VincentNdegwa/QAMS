<template>
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-primary">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Project
                </h5>
                <button type="button" class="btn-close bg-dark text-primary" data-bs-dismiss="modal"
                    aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="submitForm">
                    <div class="mb-3">
                        <label for="projectName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="projectName" v-model="form.name" required>
                    </div>
                    <!-- Other input fields -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from "@inertiajs/vue3";

export default {
    setup() {
        const form = useForm({
            name: "project",
            // other form fields
        });

        const submitForm = () => {
            // Handle form submission
        };

        return {
            form,
            submitForm
        };
    }
};
</script>
