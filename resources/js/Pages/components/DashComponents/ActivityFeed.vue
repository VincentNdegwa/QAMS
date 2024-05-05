<template>
    <div class="col-12 box-shadow">
        <div class="row text-center ">
            <div class="col-12 text-light ">Activity Feed</div>
        </div>
        <ul class="row list-unstyled overflow-y-scroll  scroll-none m-1 activity_list">
            <li v-for="(item, index) in activities" :key="index"
                class="p-1 mt-1 pointer text-secondary box-shadow d-flex flex-row justify-content-between "
                style="height: 2.4rem">
                <small class="p-0 overflow-x-hidden ellipsis w-75">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo nihil magni asperiores
                </small>
                <small class="m-0 p-0">23:05pm</small>
            </li>
        </ul>

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
    height: 30vh !important;
    max-height: 30vh !important;
    overflow-y: scroll;
}

.activity_list::-webkit-scrollbar {
    display: none
}
</style>