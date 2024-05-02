<template>
    <MainLayout>
        <div class="container py-4">
            <div class="mt-3">
                <div @click="goBack()" class="btn btn-secondary text-light">
                    Back
                </div>

            </div>
            <div class="text-center text-light h4">
                {{ testCase.title }}
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
                                <p class="text-secondary ms-2">{{ testCase.description }}</p>
                            </div>
                        </div>
                        <div class="d-flex flex-column text-case-item">
                            <div class="d-flex">
                                <p class="text-light">Status:</p>
                                <p class="text-secondary ms-2">{{ testCase.status }}</p>
                            </div>
                        </div>
                        <div class="d-flex flex-column text-case-item">
                            <div class="d-flex">
                                <p class="text-light">Module:</p>
                                <p class="text-secondary ms-2">{{ testCase.module_name }}</p>
                            </div>
                        </div>
                        <div class="d-flex flex-column text-case-item">
                            <div class="d-flex">
                                <p class="text-light">Tester:</p>
                                <p class="text-secondary ms-2">{{ testCase.tester.name }}</p>
                            </div>
                        </div>
                        <div class="d-flex flex-column text-case-item">
                            <div class="d-flex">
                                <p class="text-light">Created At:</p>
                                <p class="text-secondary ms-2">{{ formatDate(testCase.created_at) }}</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-4 col-lg-6">
                    <div class="row">
                        <div class="text-primary h5 col-6">
                            Test Steps
                        </div>
                        <div @click="addStep()" class="col-6 btn btn-primary">
                            Add Step
                        </div>
                    </div>
                    <div class="test-steps-container mt-1">
                        <div class="mt-1">

                            <div v-for="step in testCase.test_steps" :key="step.id"
                                class="box-shadow test-step-item p-4 mt-3">

                                <div class="d-flex step-details">
                                    <p class="text-light">Step:</p>
                                    <p class="text-secondary ms-2">{{ step.step_description }}</p>
                                </div>
                                <div class="d-flex step-details">
                                    <p class="text-light">Status:</p>
                                    <p class="text-secondary ms-2">{{ step.step_status }}</p>
                                </div>
                                <div class="d-flex step-details">
                                    <p class="text-light">Expected:</p>
                                    <p class="text-secondary ms-2">{{ step.expected_result.result_description }}</p>
                                </div>
                                <div class="d-flex step-details">
                                    <p class="text-light">Found:</p>
                                    <p class="text-secondary ms-2">{{ step.expected_result.found_description }}</p>
                                </div>
                                <div class="d-flex step-details">
                                    <p class="text-light">Pass:</p>
                                    <p class="text-secondary ms-2">{{ step.expected_result.pass === 'true' ? 'Yes' :
                    'No' }}</p>
                                </div>
                            </div>
                            
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "./Layouts/MainLayout.vue"
export default {
    components: {
        MainLayout
    }, props: {
        testCase: {
            type: Object
        }
    }, data() {
        return {
            completeness: {
                completed: 0,
                total: 0,
                percentage: 0
            },
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
                colors: ['#5C8374', '#ff0000'],
            },
        }
    }, mounted() {
        this.countCompleted()
        console.log(this.testCase)
    }, methods: {
        formatDate(date) {
            return new Date(date).toLocaleString();
        }, countCompleted() {
            this.completeness.total = this.testCase.test_steps.length
            this.testCase.test_steps.forEach(element => {
                if (element.step_status == "Complete") {
                    this.completeness.completed++
                }
            });
            this.completeness.percentage = (this.completeness.completed / this.completeness.total) * 100
            this.series.push(this.completeness.completed, (this.completeness.total - this.completeness.completed))
        }, goBack() {
            window.history.back()
        }, addStep() {

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
    box-shadow: 1px 0px 20px var(--bs-primary);
}

.step-details {
    padding: 2px;
    border-bottom: 1px solid gray;
}
</style>