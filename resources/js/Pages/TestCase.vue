<template>
    <SingleProject name="Test Case">
        <div class="w-100 d-flex gap-2 justify-content-end">
            <a href="new" class="btn btn-secondary text-light">
                <i class="bi bi-plus-lg"></i>
                Add Test Case
            </a>
            <a href="export" class="btn btn-primary text-light">
                <i class="bi bi-upload"></i>
                Export CSV
            </a>
            <div class="btn btn-secondary" @click="startImport" >JSON Import</div>
           
        </div>
        <div class="row ms-0 mt-3 w-100">
            <div class="col-12 col-md-4">
                <div class="w-100 m-0 d-flex justify-content-around align-items-center p-2">
                    <div class="text-secondary">Modules</div>
                    <div class="p text-light">
                        <div class="p">
                            <!-- <i class="bi bi-plus-lg"></i> -->
                        </div>
                    </div>
                </div>
                <div class="modules-scroll overflow-y-scroll">
                    <div v-for="(item, index) in moduleCount" :key="index" class="module-item d-flex p-2 mt-2 pointer"
                        @click="updateData(item.module_name)" :class="{
                            'bg-secondary':
                                testCases.length > 0 &&
                                testCases[0].module_name === item.module_name,
                        }">
                        <i class="bi bi-folder-fill text-primary"></i>
                        <div class="ms-3">
                            <span class="text-light">{{
                                item.module_name
                                }}</span>
                            <small class="ms-2 text-info">({{ item.test_count }})</small>
                        </div>
                    </div>
                </div>
            </div>
            <TestCaseTable :testCases="testCases" />
        </div>
    </SingleProject>
    <Overlay :open="importStart" @closeOverlay="closeImport" >
        <JsonImport :userId="userId" @closeImportOverlay="closeImport" @fetchTestCases="fetchTestCases"/>
    </Overlay>
</template>

<script>
import axios from "axios";
import SingleProject from "./Layouts/SingleProject.vue";
import TestCaseTable from "./components/TestCaseComponents/TestCaseTable.vue";
import Overlay from "./Layouts/Overlay.vue";
import JsonImport from "./components/TestCaseComponents/JsonImport.vue"
export default {
    props: {
        moduleCount: { type: Array },
        userId: { type: Number },
        projectId: { type: String },
    },
    data() {
        return {
            testCases: [],
            file: null,
            uploadStatus: null,
            importStart: false
        };
    },
    components: {
        SingleProject,
        TestCaseTable,
        Overlay,
        JsonImport
    },
    mounted() {
        if (this.moduleCount.length > 0) {
            this.updateData(this.moduleCount[0].module_name);
        }
    },
    methods: {
        updateData(module) {
            let data = {
                user_id: this.userId,
                project_id: this.projectId,
                module_name: module,
            };

            axios
                .post("/api/testCase/retrieve", data)
                .then((res) => {
                    if (!res.data) {
                        alert(res.data.message);
                    } else {
                        this.testCases = res.data.testCases;
                    }
                })
                .catch((err) => {
                    alert(err);
                });
        },
        startImport() {
            this.importStart = true;
        },
        closeImport() {
            this.importStart = false
        },fetchTestCases() {
           location.reload()
        }
    },
};
</script>
<style>
.upload-label {
    width: 100px;
    height: 40px;
    display: grid;
    place-items: center;
}
</style>
