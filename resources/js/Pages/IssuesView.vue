<script>
import SingleProject from "./Layouts/SingleProject.vue";
import Overlay from "./Layouts/Overlay.vue";
import AddNewIssue from "./components/IssuesComponents/AddNewIssue.vue";
import ConfirmOverlay from "./components/ConfirmOverlay.vue";
import axios from "axios";
export default {
    props: {
        project_id: {
            type: String,
        },
        issue: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            seacrh_filter: "all",
            search_input: "",
            overlay: {
                open: false,
            },
            issuesArray: [],
            editIssue: {},
            rows_per_page: 10,
            current_page: this.issue.current_page,
            startPage: this.issue.from,
            endPage: this.issue.last_page,
            startConfrim: false,
            message: "",
            selectedIssueId: "",
        };
    },
    components: {
        SingleProject,
        Overlay,
        AddNewIssue,
        ConfirmOverlay,
    },
    mounted() {
        this.issuesArray = this.issue.data;
    },
    methods: {
        toggleForm() {
            this.overlay.open = !this.overlay.open;
        },
        addIssue(issue) {
            this.issuesArray.push(issue);
        },
        badgeClass(stage) {
            if (stage === "opened") {
                return "badge badge-primary";
            } else if (stage === "in progress") {
                return "badge badge-warning";
            } else if (stage === "closed") {
                return "badge badge-success";
            }
            return "badge badge-secondary";
        },
        openEditForm(id) {
            this.editIssue = this.issuesArray.find((item) => item.id == id);
            this.toggleForm();
        },
        updateIssue(data) {
            let isssue_id = data.id;

            let index = this.issuesArray.findIndex(
                (item) => item.id == isssue_id
            );
            if (index != -1) {
                this.issuesArray[index] = data;
            }
        },
        perfomSearchAndFilter() {
            let data = {
                search: this.search_input,
                filter: this.seacrh_filter,
                page: this.current_page,
                rows_per_page: this.rows_per_page,
            };
            console.log(data);
            axios
                .post("/api/issues/searchAndFilter", data)
                .then((res) => {
                    if (!res.data.error) {
                        this.issuesArray = res.data.data.data;
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        previousPage() {
            this.current_page--;
            this.perfomSearchAndFilter();
            this.startPage = this.current_page;
        },
        nextPage() {
            this.current_page++;
            this.perfomSearchAndFilter();
            this.startPage = this.current_page;
        },
        deleteIssue(id) {
            this.startConfrim = true;
            this.message =
                "Are you sure you want to delete this issue id" +
                id +
                "?<br> <span class='text-danger text-center'>This action cannot be undone.</span>";
            this.selectedIssueId = id;
        },
        handleDelete(result) {
            this.startConfrim = false;
            if (result) {
                axios
                    .post("/api/issues/delete", {
                        id: this.selectedIssueId,
                    })
                    .then((res) => {
                        if (res.data.error) {
                            alert(res.data.message);
                        } else {
                            let index = this.issuesArray.findIndex(
                                (item) => item.id === this.selectedIssueId
                            );
                            this.issuesArray.splice(index, 1);
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
        },
    },
};
</script>
<template>
    <SingleProject>
        <div class="w-100 d-flex justify-content-end">
            <a @click="toggleForm" class="btn btn-secondary text-light">
                <i class="bi bi-plus-lg"></i>
                Add Issues
            </a>
        </div>
        <div class="d-flex justify-content-start">
            <select
                v-model="seacrh_filter"
                @change="perfomSearchAndFilter"
                class="form-control form-select-sm select-form bg-secondary text-light"
            >
                <option value="all">all</option>
                <option value="opened">opened</option>
                <option value="in progress">in progress</option>
                <option value="closed">closed</option>
            </select>
        </div>
        <div class="d-flex justify-content-start mt-2">
            <input
                v-model="search_input"
                @input="perfomSearchAndFilter"
                type="text"
                class="search-form p-2 bg-dark text-light border-1 border-primary"
                placeholder="Search by title, description, id..."
            />
        </div>
        <div class="row ms-0 mt-3 w-100 issues_table">
            <table class="table table-dark table-sm">
                <thead>
                    <tr class="text-secondary">
                        <th>Id</th>
                        <th>Project Name</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Stage</th>
                        <td class="text-green">Action</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in issuesArray" :key="index">
                        <td>{{ item?.id }}</td>
                        <td>{{ item?.project?.name }}</td>
                        <td>{{ item?.title }}</td>
                        <td>{{ item?.description }}</td>
                        <span :class="badgeClass(item?.stage)">{{
                            item?.stage
                        }}</span>
                        <td class="">
                            <div class="d-flex row">
                                <div
                                    class="btn-primary btn-sm text-primary h6 pointer col-4"
                                    @click="openEditForm(item?.id)"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </div>
                                <div
                                    class="btn-primary btn-sm text-primary h6 pointer col-4"
                                    @click="deleteIssue(item?.id)"
                                >
                                    <i class="bi bi-trash"></i>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div
            class="d-flex accordion-body flex-row justify-content-between text-light"
        >
            <div class="row-change">
                <span class="text-light"> Rows per page </span>
                <select
                    @change="perfomSearchAndFilter"
                    class="form bg-dark text-light"
                    v-model="rows_per_page"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="75">75</option>
                </select>
            </div>
            <div class="pager-nav d-flex align-items-center g-2">
                <button
                    :disabled="startPage === 1"
                    @click="previousPage"
                    class="bg-primary p-1 rounded-circle"
                >
                    <i class="bi bi-chevron-left"></i>
                </button>
                <div class="count">{{ startPage }} of {{ endPage }}</div>
                <button
                    @click="nextPage"
                    :disabled="startPage == issue.last_page"
                    class="bg-primary p-1 rounded-circle"
                >
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
        <Overlay :open="overlay.open" @closeOverlay="toggleForm">
            <AddNewIssue
                @closeForm="toggleForm"
                @updateIssue="updateIssue"
                :project_id="project_id"
                @addIssue="addIssue"
                :data="editIssue"
            />
        </Overlay>
        <ConfirmOverlay
            v-if="startConfrim"
            :message="message"
            :openOverlay="startConfrim"
            @confirmed="handleDelete"
        />
    </SingleProject>
</template>
<style>
.select-form {
    width: 20% !important;
    outline: none !important;
    border: 0 !important;
}

.pager-nav {
    & span {
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        cursor: pointer;
    }
}

option {
    border: 0 !important;
}

.search-form {
    outline: none !important;
    max-width: 500px;
    width: 100%;
    height: 40px;
    border-radius: 2px;
}

.badge-primary {
    background: green !important;
}

.badge-warning {
    background: orange !important;
}

.badge-success {
    background: red !important;
}

.issues_table {
    overflow: scroll;
    height: 70vh !important;

    &::-webkit-scrollbar {
        display: none;
    }
}

table {
    height: max-content;
}
.rounded-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 0;
    &:disabled {
        background-color: gray !important;
        cursor: not-allowed;
    }
}
</style>
