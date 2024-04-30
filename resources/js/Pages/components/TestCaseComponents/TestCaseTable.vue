<template>
    <div class="col-12 col-md-8">

        <div class="w-100 m-0 d-flex justify-content-around align-items-center p-2">
            <div class="text-secondary">
                Test Cases
            </div>
            <div class="p d-flex text-light">
                
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
                        <th scope="col">Step</th>
                        <th scope="col">Created At</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-if="testCases.length > 0" v-for="(item, index) in testCases" :key="index">
                        <td>{{ item?.id }}</td>
                        <td>{{ item?.title }}</td>
                        <td>
                            <i class="bi bi-pen ms-3 pointer"></i>
                            <i class="bi bi-trash3-fill ms-3 pointer"></i>
                        </td>
                        <td>{{ item.tester.name }}</td>

                        <td>
                            <span class="badge" :class="getClass(item.status)">{{
                        item.status }}</span>
                        </td>

                        <td>{{ new Date(item?.created_at).toLocaleString() }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>

<script>
export default {
    props: {
        testCases: {
            type: Array,
        }
    }, methods: {
        getClass(status) {
            switch (status) {
                case "Incomplete":
                    return 'text-bg-yellow';
                    break;
                case 'Complete':
                    return 'text-bg-green'
                default:
                    return 'text-bg-secondary'
                    break;
            }
        }
    }
}
</script>