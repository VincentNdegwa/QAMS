<template>
    <div class="col-12 box-shadow">
        <div class="row text-center ">
            <div class="col-12 text-secondary ">Activity Feed</div>
        </div>
        <div class="d-flex flex-column overflow-y-scroll scroll-none m-1 activity_list" v-if="activities.length > 0">
            <div v-for="(item, index) in activities" :key="index"
                class="pointer activity_text text-secondary box-shadow p-1 mt-1 d-flex flex-row text-light"
                style="height: 2.4rem">
                <small class="p-0 overflow-x-hidden ellipsis w-75">
                    <span v-html="highlightText(item.activity_text)"></span>
                </small>
                <small class="m-0 p-0">{{ new Date(item.created_at).toLocaleDateString() }}</small>
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
    }, methods: {
        highlightText(text) {
            const regex = /(@\w+)|('.*?')/g;
            return text.replace(regex, (match) => {
                if (match.startsWith('@')) {
                    return `<span style="color: blue">${match}</span>`;
                } else {
                    return `<span style="color: green">${match}</span>`;
                }
            });
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
</style>