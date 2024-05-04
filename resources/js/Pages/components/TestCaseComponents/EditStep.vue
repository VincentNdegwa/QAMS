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
            <div class="col-8" v-if="newEdit.expected_result.pass === 'false'">
                <label for="" class="form-label text-primary">Found</label>
                <textarea class=" form-control textarea" v-model="newEdit.expected_result.found_description"></textarea>
            </div>
        </div>
        <div class="row w-100  mt-5 ">
            <div class="col-md-12 w-100  col-5 text-light btn btn-danger m-2" @click="cancelOverlay">Cancel</div>
            <div class="col-md-12 w-100  col-5 btn btn-secondary m-2" @click="SubmiForm">Submit</div>
        </div>
    </form>
</template>
<script>
import axios from 'axios'

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
        }, cancelOverlay() {
            this.$emit("closeOverlay")
        }, async SubmiForm() {
            console.log(this.newEdit)
            await axios.post("/api/testStep/update", this.newEdit).then((res) => {
                if (res.data.error) {
                    alert(res.data.message)
                } else {
                    alert(res.data.message)
                    this.$emit("updateDate", res.data.data)
                }
            }).catch((err) => {
                alert(err)
            })
            await this.cancelOverlay()
        }
    }
}
</script>

