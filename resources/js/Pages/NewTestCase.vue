<script>
import SingleProject from "./Layouts/SingleProject.vue"
import Overlay from "./Layouts/Overlay.vue";
import AddModuleForm from "./components/TestCaseComponents/AddModuleForm.vue";
import { router, useForm } from "@inertiajs/vue3";
import axios from "axios";
export default {
    props: {
        organisation_id: {
            type: String
        },
        project_id: {
            type: String
        },
        modules: {
            type: Array
        },
        user: {
            type: Object
        }
    },
    components: {
        SingleProject,
        Overlay,
        AddModuleForm
    }, mounted() {
    },
    data() {

        const form = {
            tester_id: this?.user?.id,
            module: "",
            title: "",
            description: "",
            project_id: this.project_id,
            test_steps: [
                {
                    step: "",
                    expected: "",
                    pass: "false",
                    found: ""
                }
            ],
        }
        return {
            overlay: {
                open: false,
            },
            form,
            newStep: {
                open: false
            }
        }
    }, methods: {
        AddModule(module) {
            this.form.module = module
        },
        openOverlay() {
            this.overlay.open = !this.overlay.open
        },
        addStep() {
            let newStep = {
                step: "",
                expected: ""
            }
            this.form.test_steps.push(newStep)
        }, removeStep(index) {
            this.form.test_steps.splice(index, 1)
        }, createTestCase() {
            if (this.validateFullForm()) {
                axios.post("/api/testCase/add", this.form).then((res) => {
                    if (res.data.error) {
                        console.log(res.data.message)
                    } else {
                        router.visit("test")
                    }
                    console.log(res.data)
                }).catch((err) => {
                    console.log(err)
                })
                console.log(this.form)
            } else {
                console.log("Form is not valid. Show toast alerts...");
            }
        },
        validateForm() {
            if (!this.form.module || !this.form.title) {
                alert("Please fill in the required inputs")
                return false;
            }

            this.newStep.open = true
            return true;
        }, removeNewStep() {
            this.newStep.open = !this.newStep.open
        }, validateFullForm() {
            for (const step of this.form.test_steps) {
                if (!step.step || !step.expected) {
                    alert("Please Enter steps inputs")
                    return false;
                }
            }
            return true;
        }, back() {
            window.history.back()
        }
    }
}
</script>
<template>
    <SingleProject>
        <form class="needs-validation" novalidate @submit.prevent="validateForm">
            <div class="d-flex w-100 justify-content-between align-items-center">
                <div @click="back" class="btn btn-secodary"><i class="bi bi-arrow-left-circle text-secondary h3"></i>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="btn btn-danger text-light">Cancel</div>
                        <div @click="validateForm" class="btn ms-2 btn-primary">
                            Add Steps
                            <i class="bi bi-arrow-right-square-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="test-case-form">
                <div class="row h-100">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div>
                            <div class="row p-3">
                                <label for="module" class="form-label text-secondary">Module</label>
                                <select v-model="form.module" class="form-select bg-dark text-light border-secondary"
                                    id="module">
                                    <option :value="form.module">{{ form.module }}</option>
                                    <option v-for="(item, index) in modules" :key="index" :value="item.module_name">{{
            item.module_name }}</option>
                                    <!-- Add your options here -->
                                </select>
                                <div class="invalid-feedback">
                                    Please select a module.
                                </div>
                            </div>
                            <div class="row p-1 w-100 ms-0 ">
                                <div @click="openOverlay"
                                    class="d-flex justify-content-center p-1 border border-1 bg-secondary pointer add-module rounded-2 ">
                                    <small class="text-light text-center ">Or Create Module</small>

                                </div>
                            </div>
                            <div class="row p-3">
                                <label for="title" class="form-label text-secondary">Title</label>
                                <textarea v-model="form.title" class="form-control bg-dark text-light border-secondary"
                                    id="title" placeholder="Enter Title" rows="3" required></textarea>
                                <div class="invalid-feedback">
                                    Please provide a title.
                                </div>
                            </div>
                            <div class="row p-3">
                                <label for="description" class="form-label text-secondary d-flex ">
                                    Description
                                    <div class="text-primary ms-1 ">(Optionaal)</div>
                                </label>
                                <textarea v-model="form.description"
                                    class="form-control bg-dark text-light border-secondary" id="description" rows="5"
                                    required placeholder="Enter Description"></textarea>
                                <div class="invalid-feedback">
                                    Please provide a description.
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-8 col-lg-8 position-relative">
                        <Overlay :open="newStep.open" size="xlg" @closeOverlay="removeNewStep">
                            <div class="d-flex w-100 align-items-center justify-content-between position-sticky top-0">
                                <div @click="addStep" class="btn btn-secondary text-light">Add Step</div>
                                <div @click="createTestCase" class="text-black btn btn-primary">Submit</div>
                            </div>
                            <div class="steps-display overflow-y-scroll">
                                <!-- step item -->
                                <div v-if="form.test_steps.length > 0"
                                    class="row d-flex w-100 flex-row align-items-center step-item mt-2"
                                    v-for="(item, index) in form.test_steps" :key="index">
                                    <div class="col-11">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class=" col-12">
                                                        <small class="text-primary">Step</small>
                                                        <textarea v-model="item.step"
                                                            class="form-control bg-dark text-light border-secondary step-textarea"
                                                            id="description" rows="5" required
                                                            placeholder="Enter Test Step"></textarea>
                                                    </div>
                                                    <div class=" col-12">
                                                        <small class="text-primary">Expected Results</small>
                                                        <textarea v-model="item.expected"
                                                            class="form-control bg-dark text-light border-secondary step-textarea"
                                                            id="description" rows="5" required
                                                            placeholder="Enter Test Step"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-3 d-flex flex-column justify-content-center">
                                                        <div class="mb-3">
                                                            <label for="" class="form-label">Test State</label>
                                                            <select v-model="item.pass"
                                                                class="form-select form-select-sm bg-dark text-light"
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
                                                            id="description" rows="5"
                                                            placeholder="Explain the found behaviour"></textarea>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div @click="removeStep(index)" class="text-light pointer"><i
                                                class="bi bi-trash3-fill"></i></div>
                                    </div>
                                </div>
                                <div v-else class="d-flex justify-content-center align-items-center h-100 flex-column">
                                    Click the button to add a step
                                    <div @click="addStep" class="btn btn-primary">
                                        Add Step
                                    </div>
                                </div>
                            </div>
                        </Overlay>

                    </div>
                </div>
            </div>
        </form>

        <Overlay :open="overlay.open" @closeOverlay="openOverlay">
            <AddModuleForm @removeOverlay="openOverlay" @addModule="AddModule" />
        </Overlay>
    </SingleProject>
</template>
<style>
.test-case-form {
    min-height: 77vh !important;
    /* background: red; */
}

.step-textarea {
    height: 10vh;
}

.steps-display {
    height: 70vh !important;
}

.steps-display::-webkit-scrollbar {
    display: none
}

textarea {
    resize: none;
}

.add-module {
    border: 1px solid !important;
}

.step-item {
    box-shadow: 3px 4px 10px rgba(0, 0, 0, 0.6);
}
</style>