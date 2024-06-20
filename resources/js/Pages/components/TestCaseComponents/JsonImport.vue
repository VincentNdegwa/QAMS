<template>
    <div class="import-test-case">
        <div class="mt-2 text-light">
            <ol class="d-flex gap-3 flex-column">
                <li>
                    <strong>Step 1: Download Template</strong>
                    <p>
                        Download the JSON file format from the link provided
                        below. Proceed if already downloaded. The format must
                        adhere to the JSON file provided.
                    </p>
                    <ul class="bg-dark border-0 list-group">
                        <li class="bg-dark border-0 list-group-item">
                            <a
                                href="/Json-Upload-Template.json"
                                download
                                class="btn btn-primary"
                                >Download Template</a
                            >
                        </li>
                        <li
                            v-if="!step2_Open"
                            class="bg-dark border-0 list-group-item"
                        >
                            <div
                                @click="startProceed"
                                class="btn btn-sm btn-green"
                            >
                                Proceed
                            </div>
                        </li>
                    </ul>
                </li>
                <li v-if="step2_Open">
                    <strong>Step 2: Upload Your JSON File</strong>
                    <p>
                        Once you have prepared your JSON file, upload it using
                        the file input below.
                    </p>
                    <input
                        type="file"
                        @change="handleFileUpload"
                        accept=".json"
                        class="form-control mt-1 w-10"
                    />
                </li>
                <li v-if="step3_Open">
                    <strong>Step 3: All Done</strong>
                    <p>Your JSON file has been successfully uploaded.</p>
                    <ul class="bg-dark border-0 list-group">
                        <li class="bg-dark border-0 list-group-item">
                            <div @click="uploadFile" class="mt-2 btn btn-secondary">Upload File</div>
                        </li>
                    </ul>
                </li>
            </ol>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        userId: {
            type: Number,
        },
    },
    data() {
        return {
            jsonContent: null,
            step2_Open: false,
            step3_Open: false,
            file: null,
        };
    },
    methods: {
        startProceed() {
            this.step2_Open = true;
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
            this.step3_Open = true;
        },
        async uploadFile() {
            if (!this.file) {
                alert("Please select a file.");
                return;
            }

            const formData = new FormData();
            formData.append("file", this.file);
            formData.append("tester_id", this.userId);

            try {
                const response = await axios.post("upload-json", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });

                this.$emit('closeImportOverlay')
                this.$emit('fetchTestCases')
             
            } catch (error) {
                this.uploadStatus = {
                    error: true,
                    message:
                        error.response.data.message ||
                        "An error occurred while uploading the file.",
                };
            }
        },
    },
};
</script>

<style></style>
