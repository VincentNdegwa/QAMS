<script>
import SingleProject from "./Layouts/SingleProject.vue"
export default {
    props: {
        moduleCount: { type: Array },

    },
    data() {
        return {
            testCases: [],
        }
    },
    components: {
        SingleProject,
    }, mounted() {
        if (this.moduleCount.length > 0) {
            this.updateData(this.moduleCount[0].module_name);
        }
    }, methods: {
        updateData(module) {
        }
    }
}
</script>
<template>
    <SingleProject>
        <div class="w-100 d-flex justify-content-end">
            <a href="new" class="btn btn-secondary text-light">
                <i class="bi bi-plus-lg"></i>
                Add Issues
            </a>
        </div>
        <div class="row ms-0  mt-3 w-100 ">
            <div class="col-12 col-md-4">
                <div class="w-100 m-0 d-flex justify-content-around align-items-center p-2">
                    <div class="text-secondary">
                        Modules
                    </div>
                    <div class="p text-light">
                        <div class="p">
                            <!-- <i class="bi bi-plus-lg"></i> -->
                        </div>
                    </div>
                </div>
                <div class="modules-scroll overflow-y-scroll">
                    <div v-for="(item, index) in moduleCount" :key="index" class="module-item d-flex p-2 mt-2 pointer"
                        @click="updateData(item.module_name)"
                        :class="{ 'bg-secondary': testCases.length > 0 && testCases[0].module_name === item.module_name }">
                        <i class="bi bi-folder-fill text-primary"></i>
                        <div class="ms-3">
                            <span class="text-light">{{ item.module_name }}</span>
                            <small class="ms-2 text-info">({{ item.test_count }})</small>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 col-md-4">

                display
            </div>

        </div>

    </SingleProject>
</template>
