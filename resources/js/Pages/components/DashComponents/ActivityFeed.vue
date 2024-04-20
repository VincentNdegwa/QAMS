<template>
    <div class="activity_list">
        <div class="list-group">
            <a v-for="(item, index) in activities" :key="index" href="#"
                class="list-group-item list-group-item-action bg-dark text-secondary ">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ item.name }}</h5>
                    <small>{{ item.time }}</small>
                </div>
            </a>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            activities: [
                { name: 'Meeting', time: '10:00 AM' },
                { name: 'Lunch', time: '12:30 PM' },
                { name: 'Presentation', time: '02:00 PM' },
                { name: 'Lunch', time: '12:30 PM' },
                { name: 'Lunch', time: '12:30 PM' },
                { name: 'Meeting', time: '10:00 AM' },
                { name: 'Lunch', time: '12:30 PM' },
                { name: 'Presentation', time: '02:00 PM' },
                { name: 'Lunch', time: '12:30 PM' },
                { name: 'Lunch', time: '12:30 PM' },
                { name: 'Meeting', time: '10:00 AM' },
                { name: 'Lunch', time: '12:30 PM' },
                { name: 'Presentation', time: '02:00 PM' },
                { name: 'Lunch', time: '12:30 PM' },
                { name: 'Lunch', time: '12:30 PM' },
            ],
        }
    }
}
</script>

<style>
.activity_list {
    height: 330px !important;
    max-height: 330px !important;
    overflow-y: scroll;
}

.activity_list::-webkit-scrollbar {
    display: none
}
</style>