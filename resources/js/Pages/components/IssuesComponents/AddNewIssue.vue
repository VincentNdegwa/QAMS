<template>
    <form @submit.prevent="handleSubmit">
        <div class="form-group mt-1">
            <label for="title">Title:</label>
            <input
                type="text"
                class="form-control"
                id="title"
                v-model="formData.title"
                required
            />
        </div>
        <div class="form-group mt-2">
            <label for="description">Description:</label>
            <textarea
                class="form-control"
                id="description"
                v-model="formData.description"
                required
            ></textarea>
        </div>
        <div class="form-group mt-2">
            <label for="stage">Stage:</label>
            <select
                class="form-control"
                id="stage"
                v-model="formData.stage"
                required
            >
                <option value="opened" selected>opened</option>
                <option value="in progress">in progress</option>
                <option value="closed">closed</option>
            </select>
        </div>
        <div class="form-group mt-4">
            <button
                v-if="formData.id"
                type="button"
                @click="updateIssue"
                class="btn btn-primary m-2"
            >
                Update
            </button>
            <button v-else type="submit" class="btn btn-primary m-2">
                Submit
            </button>
            <button
                type="button"
                class="btn btn-danger m-2"
                @click="handleCancel"
            >
                Cancel
            </button>
        </div>
    </form>
</template>
<script>
import axios from "axios";
export default {
    props: {
        project_id: {
            type: String,
        },
        data: {
            type: Object,
        },
    },
    data() {
        return {
            formData: {
                title: "",
                description: "",
                stage: "opened",
                project_id: this.project_id,
            },
        };
    },
    methods: {
        handleSubmit() {
            axios
                .post("/api/issues/add", this.formData)
                .then((res) => {
                    if (!res.data.error) {
                        this.$emit("addIssue", res.data.data);
                    } else {
                        alert(res.data.message);
                    }
                })
                .catch((err) => {
                    alert(err);
                });
            this.handleCancel();
        },
        handleCancel() {
            this.$emit("closeForm");
        },
        updateIssue() {
            axios
                .post("/api/issues/update", this.formData)
                .then((res) => {
                    if (!res.data.error) {
                        this.$emit("updateIssue", res.data.data);
                        this.formData = {
                            title: "",
                            description: "",
                            stage: "opened",
                            project_id: this.project_id,
                        };
                    } else {
                        alert(res.data.message);
                    }
                })
                .catch((err) => {
                    alert(err);
                });
            this.handleCancel();
        },
    },
    watch: {
        data: {
            handler: function (newData, oldData) {
                let latestData = {
                    id: newData.id,
                    title: newData.title,
                    description: newData.description,
                    stage: newData.stage,
                };
                this.formData = latestData;
            },
            deep: true,
        },
    },
};
</script>
