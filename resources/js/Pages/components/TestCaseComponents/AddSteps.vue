<template>
    <div class="d-flex w-100 align-items-center justify-content-between position-sticky top-0">
        <div @click="addStep" class="btn btn-secondary text-light">Add Step</div>
        <div @click="sendTheSteps" class="text-black btn btn-primary">Submit</div>
    </div>
    <div class="steps-display steps-display-100 overflow-y-scroll">
        <!-- step item -->
        <div v-if="form.test_steps.length > 0" class="row d-flex w-100 flex-row align-items-center step-item mt-2"
            v-for="(item, index) in form.test_steps" :key="index">
            <div class="col-11">
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class=" col-12">
                                <small class="text-primary">Step</small>
                                <textarea v-model="item.step"
                                    class="form-control bg-dark text-light border-secondary step-textarea"
                                    id="description" rows="5" required placeholder="Enter Test Step"></textarea>
                            </div>
                            <div class=" col-12">
                                <small class="text-primary">Expected Results</small>
                                <textarea v-model="item.expected"
                                    class="form-control bg-dark text-light border-secondary step-textarea"
                                    id="description" rows="5" required placeholder="Enter Test Step"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-3 d-flex flex-column justify-content-center">
                                <div class="mb-3">
                                    <label for="" class="form-label">Test State</label>
                                    <select v-model="item.pass" class="form-select form-select-sm bg-dark text-light"
                                        name="state" id="">
                                        <option value="false">False</option>
                                        <option value="true">True</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-8" v-if="item.pass === 'false'">
                                <small class="text-primary">Found Results</small>
                                <textarea v-model="item.found"
                                    class="form-control bg-dark text-light border-secondary step-textarea"
                                    id="description" rows="5" placeholder="Explain the found behaviour"></textarea>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-1">
                <div @click="removeStep(index)" class="text-light pointer"><i class="bi bi-trash3-fill"></i></div>
            </div>
        </div>
        <div v-else class="d-flex justify-content-center align-items-center h-100 flex-column">
            Click the button to add a step
            <div @click="addStep" class="btn btn-primary">
                Add Step
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    props: {
        testCase_id: {
            type: String
        }
    },
    data() {
        return {
            form: {
                test_steps: []
            }
        };
    },
    methods: {
        addStep() {
            this.form.test_steps.push({
                step: '',
                expected: '',
                pass: 'true',
                found: ''
            });
        },
        removeStep(index) {
            this.form.test_steps.splice(index, 1);
        },
        sendTheSteps() {
            axios.post("/api/testStep/add", {
                testCase_id: this.testCase_id,
                data: this.form
            }).then((res) => {
                if (res.data.error) {
                    alert(res.data.message);
                } else {
                    console.log(res.data.message)
                }
            }).catch((err) => {
                console.log(err)
            })
        }
    }
};
</script>
<style>
.steps-display-100 {
    height: 90vh !important;
}
</style>
