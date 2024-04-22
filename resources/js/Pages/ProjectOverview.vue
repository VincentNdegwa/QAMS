<template>
    <SingleProject>
        <div class="row top-stats ms-1 mt-3 ">
            <div class="col-12 top-start-1">
                <div class="row">
                    <div class="col-12 col-sm-6 bg-dark mt-5">
                        <apexchart width="400" type="donut" :options="options" :series="series"></apexchart>
                    </div>
                    <div class="col-12 col-sm-6 mt-3">
                        <apexchart width="500" type="bar" :options="Baroptions" :series="Barseries"></apexchart>
                    </div>
                </div>
            </div>
        </div>
    </SingleProject>
</template>
<script>
import SingleProject from './Layouts/SingleProject.vue';
export default {
    components: {
        SingleProject
    }, data() {
        return {
            series: [44, 55],
            options: {
                labels: ['Completed', 'Remaining'],
                responsive: [{
                    options: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
            },
            Baroptions: {
                chart: {
                    id: 'modules-bar',
                    toolbar: {
                        show: false
                    }
                },
                grid: {
                    show: false
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        borderRadiusApplication: 'end',
                        horizontal: true,
                    }
                },
                xaxis: {
                    categories: ["contact", "header", "footer", "search", "cart"]
                }
            },
            Barseries: [{
                name: 'modules',
                data: [30, 40, 45, 50, 49]
            }]
        }
    }
}
</script>
<style>
.top-stats {
    min-height: 40vh !important;
}

.top-start-1 {
    box-shadow: 3px 5px 30px rgba(0, 0, 0, 0.5) !important;
}
</style>