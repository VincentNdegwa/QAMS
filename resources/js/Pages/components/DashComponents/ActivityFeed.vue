<template>
    <div class="col-12 box-shadow">
        <div class="row text-center ">
            <div class="col-12 text-light ">Activity Feed</div>
        </div>
        <div class="d-flex flex-column overflow-y-scroll scroll-none m-1 activity_list" v-if="activities.length > 0">
            <div v-for="(item, index) in activities" :key="index"
                class="pointer activity_text text-secondary box-shadow p-1 mt-1 d-flex flex-row" style="height: 2.4rem">
                <small class="p-0 overflow-x-hidden ellipsis w-75">
                    {{ item.activity_text }} </small>
                <small class="m-0 p-0">{{ item.created_at }}</small>
            </div>
        </div>
        <div class="h-100 activity_list d-grid justify-content-center align-content-center" v-else>
            <p>You have no activities</p>
        </div>

    </div>
</template>
<script>
export default {
    props: {
        activities: {
            type: Array
        }
    },
    data() {
        return {
        }
    }
}
</script>

<style>
.activity_list {
    height: 30vh !important;
    max-height: 30vh !important;
    overflow-y: scroll;
}

.activity_list::-webkit-scrollbar {
    display: none
}

.activity_text {
    color: #187da2 !important;
    /* color: #95b3a6 !important; */
}
</style>