<template>
    <MainLayout>
        <div class="container py-4">
            <div class="mt-3">
                <div @click="goBack()" class="btn btn-secondary text-light">
                    Back
                </div>

            </div>
            <div class="text-center text-light h4">
                {{ newtestCase.title }}
            </div>
            <div class="row">
                <div class="col-12 col-md-4 col-lg-6 h-100 d-flex flex-column ">
                    <div class="text-primary h5">
                        TesCase Details
                    </div>
                    <div class="bg-dark">
                        <div class="text-light ">
                            TesCase Completeness
                        </div>
                        <div class="mt-3">
                            <apexchart width="400" type="donut" :options="options" :series="series"></apexchart>
                        </div>
                    </div>
                    <div class="test-case-details">

                        <div class="d-flex flex-column text-case-item">
                            <div class="d-flex">
                                <p class="text-light">Description:</p>
                                <p class="text-secondary ms-2">{{ newtestCase.description }}</p>
                            </div>
                        </div>
                        <div class="d-flex flex-column text-case-item">
                            <div class="d-flex">
                                <p class="text-light">Status:</p>
                                <p class="text-secondary ms-2">{{ newtestCase.status }}</p>
                            </div>
                        </div>
                        <div class="d-flex flex-column text-case-item">
                            <div class="d-flex">
                                <p class="text-light">Module:</p>
                                <p class="text-secondary ms-2">{{ newtestCase.module_name }}</p>
                            </div>
                        </div>
                        <div class="d-flex flex-column text-case-item">
                            <div class="d-flex">
                                <p class="text-light">Tester:</p>
                                <p class="text-secondary ms-2">{{ newtestCase.tester?.name }}</p>
                            </div>
                        </div>
                        <div class="d-flex flex-column text-case-item">
                            <div class="d-flex">
                                <p class="text-light">Created At:</p>
                                <p class="text-secondary ms-2">{{ formatDate(newtestCase?.created_at) }}</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-4 col-lg-6">
                    <div class="row">
                        <div class="text-primary h5 col-6">
                            Test Steps
                        </div>
                        <div @click="openOverlay()" class="col-6 btn btn-primary">
                            Add Step
                        </div>
                    </div>
                    <div class="test-steps-container mt-1">
                        <div class="mt-1">

                            <div v-for="step in newtestCase?.test_steps" :key="step.id"
                                class="box-shadow test-step-item p-4 mt-1 step-item">
                                <div class="edit-actions">
                                    <i class="bi bi-pencil me-2 pointer text-green" data-bs-toggle="popover"
                                        @click="editStep(step.id)" title="Edit"
                                        data-bs-content="Click to edit this item" data-bs-trigger="hover">
                                    </i>
                                    <i class="bi bi-trash-fill me-2 pointer text-danger" data-bs-toggle="popover"
                                        @click="deleteStep(step.id)" title="Delete"
                                        data-bs-content="Click to delete this item" data-bs-trigger="hover">
                                    </i>
                                </div>

                                <div class="d-flex step-details">
                                    <p class="text-light">Step:</p>
                                    <p class="text-secondary ms-2">{{ step?.step_description }}</p>
                                </div>
                                <div class="d-flex step-details">
                                    <p class="text-light">Status:</p>
                                    <p class="text-secondary ms-2">{{ step?.step_status }}</p>
                                </div>
                                <div class="d-flex step-details">
                                    <p class="text-light">Expected:</p>
                                    <p class="text-secondary ms-2">{{ step?.expected_result?.result_description }}</p>
                                </div>
                                <div class="d-flex step-details">
                                    <p class="text-light">Found:</p>
                                    <p class="text-secondary ms-2">{{ step?.expected_result?.found_description }}</p>
                                </div>
                                <div class="d-flex step-details">
                                    <p class="text-light">Pass:</p>
                                    <p class="text-secondary ms-2">{{ step?.expected_result?.pass === 'true' ? 'Yes' :
                    'No' }}</p>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
    <Overlay :open="overlay.open" size="lg" @closeOverlay="openOverlay">
        <AddSteps :testCase_id="testCase_id" @closeOverlay="openOverlay" />
    </Overlay>
    <Overlay :open="overlay.edit" @closeOverlay="closeEditOverlay" v-if="overlay.edit">
        <EditStep :editData="editData" @closeOverlay="closeEditOverlay" @updateDate="updateDate" />
    </Overlay>
</template>

<script>
import MainLayout from "./Layouts/MainLayout.vue"
import Overlay from "./Layouts/Overlay.vue"
import AddSteps from "./components/TestCaseComponents/AddSteps.vue"
import EditStep from "./components/TestCaseComponents/EditStep.vue"
export default {
    components: {
        MainLayout,
        Overlay,
        AddSteps,
        EditStep
    }, props: {
        testCase: {
            type: Object
        },
        testCase_id: {
            type: String
        }
    }, data() {
        return {
            newtestCase: {},
            completeness: {
                completed: 0,
                total: 0,
                percentage: 0
            }, editData: {},
            series: [],
            options: {
                labels: ['Completed', 'Remaining'],
                responsive: [{
                    options: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                colors: ['#7FFF00', '#EE4B2B'],
            },
            overlay: {
                open: false,
                edit: false
            }
        }
    }, mounted() {
        this.newtestCase = this.testCase
        this.countCompleted()
    }, methods: {
        formatDate(date) {
            return new Date(date).toLocaleString();
        }, countCompleted() {
            this.completeness.total = this.newtestCase.test_steps.length
            this.newtestCase.test_steps.forEach(element => {
                if (element.step_status == "Complete") {
                    this.completeness.completed++
                }
            });
            this.completeness.percentage = (this.completeness.completed / this.completeness.total) * 100
            this.series.push(this.completeness.completed, (this.completeness.total - this.completeness.completed))
        }, goBack() {
            window.history.back()
        }, openOverlay() {
            this.overlay.open = !this.overlay.open
        }, editStep(id) {
            this.editData = this.testCase.test_steps.find((item) => item.id == id);
            this.closeEditOverlay()
        }, deleteStep(id) {

        }, closeEditOverlay() {
            this.overlay.edit = !this.overlay.edit
        }, updateDate(data) {
            this.newtestCase = data.testCase
            this.completeness = {
                completed: 0,
                total: 0,
                percentage: 0
            }
            this.series = []
            console.log(this.completeness)

            this.countCompleted()
        }
    }
}

</script>

<style>
.test-steps-container {
    height: 79vh;
    overflow-y: scroll;
    padding: 6px;

    &::-webkit-scrollbar {
        display: none;
    }
}


.test-step-item {
    box-shadow: 1px 0px 20px var(--bs-dark);
}

.step-details {
    padding: 2px;
    border-bottom: 1px solid gray;
}

.step-item {
    position: relative;
}

.edit-actions {
    position: absolute;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    gap: 1;
}
</style>