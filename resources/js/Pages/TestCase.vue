<template>
    <SingleProject name="Test Case">
        <div class="w-100 d-flex justify-content-end">
            <a href="new" class="btn btn-secondary text-light">
                <i class="bi bi-plus-lg"></i>
                Add Test Case
            </a>
        </div>
        <div class="row ms-0  mt-3 w-100 ">
            <div class="col-12 col-md-4">
                <div class="w-100 m-0 d-flex justify-content-around align-items-center p-2">
                    <div class="text-secondary">
                        Modules
                    </div>
                    <div class="p text-light">
                        <div class="p">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="modules-scroll overflow-y-scroll ">
                    <div class="module-item d-flex pd-1">
                        <i class="bi bi-folder-fill text-primary"></i>
                        <div class="ms-3">
                            <span class="text-light">Module Name</span>
                            <small class="ms-1">(1)</small>
                        </div>
                        <i class="bi bi-trash3-fill ms-3 pointer "></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="w-100 m-0 d-flex justify-content-around align-items-center p-2">
                    <div class="text-secondary">
                        Test Cases
                    </div>
                    <div class="p d-flex text-light">
                        <div class="p ms-3 ">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                        <div class="p ms-3 ">
                            <i class="bi bi-trash3-fill ms-3 "></i>
                        </div>
                    </div>
                </div>
                <div class="d-flex w-100 align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        Show
                        <select name="" class="bg-dark text-light border-0" id="">
                            <option value="">10</option>
                            <option value="">15</option>

                        </select>
                    </div>
                    <nav class="pag-nav bg-dark">
                        <ul class="pagination pagination">
                            <li class="page-item" aria-current="page">
                                <span class="page-link">1</span>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                        </ul>
                    </nav>

                </div>
                <div class="table-container overflow-scroll  table-page">
                    <table class="table table-striped table-sm table-dark">
                        <thead>
                            <tr>
                                <th scope="col">Case Code</th>
                                <th scope="col">Title</th>
                                <th scope="col">Actions</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>C123</td>
                                <td>Case Title 1</td>
                                <td>
                                    <i class="bi bi-pen ms-3 "></i>
                                    <i class="bi bi-trash3-fill ms-3 "></i>
                                </td>
                                <td>John Doe</td>
                                <td>2024-04-25 10:00 AM</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </SingleProject>
</template>

<script>
import SingleProject from "./Layouts/SingleProject.vue"
export default {
    components: {
        SingleProject
    }
}
</script>
<style>
.page-item,
.page-link {
    background: var(--bs-dark) !important;
    color: var(--bs-light);
}

.p,
p {
    margin: 0 !important;
}

th {
    color: var(--bs-secondary) !important;
    font-size: 12px !important;
}

td {
    font-size: 12px;
}

.modules-scroll {
    height: 70vh !important;
    max-height: 70vh !important;
    min-height: 70vh !important;
}

.table-page {
    height: calc(70vh - 50px);

}

.table-page::-webkit-scrollbar {
    display: none
}


.modules-scroll::-webkit-scrollbar {
    width: 5px;
}

.modules-scroll::-webkit-scrollbar-track {
    background: var(--bs-light);
    width: 6px;
}

.modules-scroll::-webkit-scrollbar-thumb {
    background: var(--bs-primary);
}

.modules-scroll::-webkit-scrollbar-button {
    display: none;
}

.module-item {
    font-size: 13px;
}

select {
    height: max-content;
    width: 50px;
    outline: none;
}
</style>