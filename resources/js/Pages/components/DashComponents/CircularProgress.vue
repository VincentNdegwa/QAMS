<template>
    <div class="progress-holder">
        <apexchart type="donut" :options="chartOptions" :series="chartSeries" width="300" />
    </div>
</template>

<script>

export default {

    props: {
        completedTasks: {
            type: Number,
            default: 30,
        },
        totalTasks: {
            type: Number,
            default: 100,
        },
    },
    data() {
        return {
            chartOptions: {
                labels: ['Completed', 'Remaining'],
                responsive: [{
                    options: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
            },
            // Define chart series data
            chartSeries: [this.completedTasks, this.totalTasks - this.completedTasks],
        };
    },
};
</script>
