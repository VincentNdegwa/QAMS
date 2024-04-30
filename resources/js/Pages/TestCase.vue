<template>
    <SingleProject name="Test Case">
        <div class="w-100 d-flex justify-content-end">
            <a href="new" class="btn btn-secondary text-light">
                <i class="bi bi-plus-lg"></i>
                Add Test Case
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
            <TestCaseTable :testCases="testCases" />

        </div>


    </SingleProject>
</template>

<script>
import axios from "axios"
import SingleProject from "./Layouts/SingleProject.vue"
import TestCaseTable from "./components/TestCaseComponents/TestCaseTable.vue"
export default {
    props: {
        moduleCount: { type: Array },
        userId: { type: Number },
        projectId: { type: String }
    },
    data() {
        return {
            testCases: [],
        }
    },
    components: {
        SingleProject,
        TestCaseTable
    }, mounted() {
        if (this.moduleCount.length > 0) {
            this.updateData(this.moduleCount[0].module_name);
        }
    }, methods: {
        updateData(module) {
            let data = {
                user_id: this.userId,
                project_id: this.projectId,
                module_name: module
            }

            axios.post("/api/testCase/retrieve", data).then((res) => {
                if (!res.data) {
                    alert(res.data.message)
                } else {
                    this.testCases = res.data.testCases
                    console.log(this.testCases)
                }
            }).catch((err) => {
                alert(err)
            })
        }
    }
}
</script>
<style>
.page-item,
.page-link {
    background: var(--bs-dark) !important;
    color: var(--bs-light);
}

.p,
p {
    margin: 0 !important;
}

th {
    color: var(--bs-secondary) !important;
    font-size: 12px !important;
}

td {
    font-size: 12px;
}

.modules-scroll {
    height: 70vh !important;
    max-height: 70vh !important;
    min-height: 70vh !important;
}

.table-page {
    height: calc(70vh - 50px);

}

.table-page::-webkit-scrollbar {
    display: none
}


.modules-scroll::-webkit-scrollbar {
    width: 5px;
}

.modules-scroll::-webkit-scrollbar-track {
    background: var(--bs-light);
    width: 6px;
}

.modules-scroll::-webkit-scrollbar-thumb {
    background: var(--bs-primary);
}

.modules-scroll::-webkit-scrollbar-button {
    display: none;
}

.module-item {
    font-size: 13px;

    &:hover {
        background-color: var(--bs-secondary) !important;
    }
}

select {
    height: max-content;
    width: 50px;
    outline: none;
}
</style>