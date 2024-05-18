<template>
    <div class="overlay-dialog">
        <div class="overlay-content bg-dark text-primary">
            <div class="overlay-header">
                <h5 class="overlay-title" id="exampleoverlayLabel">
                    Create Project
                </h5>
                <button
                    type="button"
                    @click="closeOverlay"
                    class="btn bg-dark text-primary"
                >
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="overlay-body">
                <form @submit.prevent="submitForm">
                    <div class="mb-3">
                        <label for="projectName" class="form-label">Name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="projectName"
                            v-model="form.name"
                            required
                        />
                    </div>
                    <!-- Other input fields -->
                    <button
                        v-if="projectData && form.id"
                        type="button"
                        class="btn btn-primary"
                        @click="updateProject"
                    >
                        Update
                    </button>
                    <button v-else type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from "@inertiajs/vue3";
import axios from "axios";

export default {
    props: {
        org_id: {
            type: String,
            default: "",
        },
        user_id: {
            type: Number,
        },
        projectData: {
            type: Object,
            default: {},
            required: false,
        },
    },
    data() {
        const form = useForm({
            name: "project",
            company_id: this.org_id,
            user_id: this.user_id,
        });

        return {
            form,
        };
    },
    methods: {
        closeOverlay() {
            this.$emit("close0verlay");
        },
        submitForm() {
            axios.post("/api/project/add", this.form).then((res) => {
                if (!res.data.error) {
                    this.$emit("updateData", res.data.project);
                } else {
                    console.log(res.data);
                }
                this.closeOverlay();
            });
        },
        updateProject() {
            console.log("sending");
            let data = {
                user_id: this.user_id,
                id: this.form.id,
                name: this.form.name,
            };
            axios.post("/api/project/update", data).then((res) => {
                if (!res.data.error) {
                    this.$emit("editData", res.data.project);
                } else {
                    console.log(res.data);
                }
                this.closeOverlay();
            });
        },
    },
    watch: {
        projectData: {
            handler: function (newData, oldData) {
                this.form = newData;
            },
            deep: true,
        },
    },
};
</script>
