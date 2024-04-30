<template>
    <div class="col-12 col-md-8 col-lg-8 position-relative">
        <div class="d-flex w-100 align-items-center justify-content-between position-sticky top-0">
            <div @click="addStep" class="btn btn-secondary text-light">Add Step</div>
            <div class="text-secondary">Test Steps</div>
        </div>
        <div class="steps-display overflow-y-scroll">
            <!-- step item -->
            <div class="row d-flex w-100 flex-row align-items-center step-item" v-for="(item, index) in form.test_steps"
                :key="index">
                <div class="col-11">
                    <div class="row">
                        <div class=" col-12 col-md-6">
                            <small class="text-primary">Step</small>
                            <textarea v-model="item.step"
                                class="form-control bg-dark text-light border-secondary step-textarea" id="description"
                                rows="5" required placeholder="Enter Test Step"></textarea>
                        </div>
                        <div class=" col-12 col-md-6">
                            <small class="text-primary">Expected Results</small>
                            <textarea v-model="item.expected"
                                class="form-control bg-dark text-light border-secondary step-textarea" id="description"
                                rows="5" required placeholder="Enter Test Step"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-1">
                    <div @click="removeStep(index)" class="text-light pointer"><i class="bi bi-trash3-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {

    }, components: {
        SingleProject
    }
}
</script>