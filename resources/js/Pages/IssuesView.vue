<script>
import SingleProject from "./Layouts/SingleProject.vue";
import Overlay from "./Layouts/Overlay.vue";
import AddNewIssue from "./components/IssuesComponents/AddNewIssue.vue";
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
            current_page: this.issue.current_page,
        };
    },
    components: {
        SingleProject,
        Overlay,
        AddNewIssue,
    },
    mounted() {
        this.issuesArray = this.issue.data;
        console.log(this.issue);
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
            };
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
        },
        nextPage() {
            this.current_page++;
            this.perfomSearchAndFilter();
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
                        <td>{{ item?._project?.name }}</td>
                        <td>{{ item?.title }}</td>
                        <td>{{ item?.description }}</td>
                        <span :class="badgeClass(item?.stage)">{{
                            item?.stage
                        }}</span>
                        <td>
                            <div
                                class="btn-primary btn-sm text-primary h5 pointer"
                                @click="openEditForm(item?.id)"
                            >
                                <i class="bi bi-pencil-square"></i>
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
                <select class="form bg-dark text-light">
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="75">75</option>
                </select>
            </div>
            <div class="pager-nav d-flex align-items-center">
                <span
                    @click="previousPage"
                    class="bg-primary p-1 rounded-circle"
                    ><i class="bi bi-chevron-left"></i
                ></span>
                <div class="count">
                    {{ issue.from }} of {{ issue.last_page }}
                </div>
                <span @click="nextPage" class="bg-primary p-1 rounded-circle"
                    ><i class="bi bi-chevron-right"></i
                ></span>
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
</style>
