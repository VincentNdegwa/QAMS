<template>
    <form @submit.prevent="addModule">
        <div class="mb-3">
            <label for="organizationName" class="form-label">Module Name</label>
            <input type="text" class="form-control" id="organizationName" v-model="module.name" required>
        </div>
        <div class="d-flex flex-row">
            <button type="submit" class="btn btn-primary w-100 m-2">Submit</button>
            <button @click="removeOverlay" type="button" class="btn btn-danger text-light w-100 m-2">Cancel</button>
        </div>
    </form>
</template>
<script>
export default {
    methods: {
        addModule() {
            this.$emit("addModule", this.module.name)
            this.removeOverlay()
        },
        removeOverlay() {
            this.$emit("removeOverlay")
        }
    },
    data() {
        return {
            module: {
                name: ""
            }
        }
    }
}
</script>