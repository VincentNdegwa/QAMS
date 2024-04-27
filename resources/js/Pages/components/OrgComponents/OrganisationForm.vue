<template>
    <div class="overlay-dialog">
        <div class="overlay-content bg-dark text-primary">
            <div class="overlay-header">
                <h5 class="overlay-title" id="exampleModalLabel">Create Organisation</h5>
                <button @click="removeOverlay" type="button" class="btn bg-dark text-primary"><i
                        class="bi bi-x-lg"></i></button>
            </div>
            <div class="overlay-body">
                <form @submit.prevent="submitOrganizationForm">
                    <div class="mb-3">
                        <label for="organizationName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="organizationName" v-model="organizationForm.name"
                            required>
                    </div>
                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="userId" v-model="organizationForm.user_id"
                            readonly required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
export default {
    props: {
        user_id: {
            type: Number,
        }
    },
    data() {
        const organizationForm = reactive({
            name: '',
            user_id: ''
        })
        return {
            organizationForm
        }
    }, methods: {
        submitOrganizationForm() {
            if (this.organizationForm.name && this.user_id) {
                axios.post("/api/organisation/add", this.organizationForm).then(response => {
                    console.log(response.data);
                    if (!response.data.error) {
                        this.removeOverlay()
                        let newOrg = response.data?.organisation
                        this.$emit("new_org", newOrg);
                    }
                }).catch((error) => {
                    console.log(error);
                });
            } else {
                alert('Please fill out all fields')
            }
        },
        removeOverlay() {
            this.$emit("removeOverlay")
        }
    }, mounted() {
        this.organizationForm.user_id = this.user_id
    }
}</script>