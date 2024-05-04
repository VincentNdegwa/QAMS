<template>
    <form class="form-control bg-dark text-light border-0 ">
        <div class="row">
            <div class="col-6 d-flex flex-column">
                <label for="" class="form-label text-primary">Step</label>
                <textarea class=" form-control textarea" v-model="newEdit.step_description"></textarea>
            </div>
            <div class="col-6 d-flex flex-column">
                <label for="" class="form-label text-primary">Expected</label>
                <textarea class=" form-control textarea"
                    v-model="newEdit.expected_result.result_description"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label class="form-label text-primary">Status</label>
                <select class="form-control border-0 form-select-sm" v-model="newEdit.expected_result.pass">
                    <option class="form-control" selected>Select Status</option>
                    <option value="false">False</option>
                    <option value="true">True</option>
                </select>
            </div>
            <div class="col-8" v-if="newEdit.expected_result.pass === 'true'">
                <label for="" class="form-label text-primary">Found</label>
                <textarea class=" form-control textarea" v-model="newEdit.expected_result.found_description"></textarea>
            </div>
        </div>
    </form>
</template>
<script>
export default {
    props: {
        editData: {
            type: Object
        }
    }, mounted() {
        this.updateData(this.editData)
    }, data() {
        return {
            newEdit: {
                step_description: "",
                expected_result: {
                    result_description: "",
                    found_description: "",
                    pass: "true"
                }
            }
        }
    }, methods: {
        updateData(data) {
            this.newEdit = data
        }
    }
}
</script>

<!-- {
"id": 9,
"testcase_id": 9,
"step_description": "first",
"step_status": "Complete",
"created_at": "2024-05-01T18:45:28.000000Z",
"updated_at": "2024-05-01T18:45:28.000000Z",
"expected_result": {
"id": 7,
"test_step_id": 9,
"result_description": "efrsfdf",
"created_at": "2024-05-01T18:45:28.000000Z",
"updated_at": "2024-05-01T18:45:28.000000Z",
"found_description": "",
"pass": "true"
}
} -->