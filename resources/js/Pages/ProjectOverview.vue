<template>
    <SingleProject>
        <div class="row top-stats ms-md-1 mt-3 ">
            <div class="col-12 box-shadow">
                <div class="row">
                    <div class="col-12 col-lg-6 bg-dark mt-3 ">
                        <div class="col-12 text-light ">
                            Project Completeness
                        </div>
                        <div class="col-12 mt-3">
                            <apexchart width="400" type="donut" :options="options" :series="series"></apexchart>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mt-3">
                        <div class="col-12 text-light ">
                            Module Count
                        </div>
                        <div class="col-12">
                            <apexchart type="bar" :options="Baroptions" :series="Barseries"></apexchart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row top-stats mt-3 ">
            <!--  -->
            <div class="col-12 col-lg-5 box-shadow">
                <div class="row">
                    <div class="col-12 text-light ">
                        Stages is Modules
                    </div>
                    <div class="col-12">
                        <apexchart type="area" :options="Baroptions" :series="Barseries"></apexchart>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="col-12 col-lg-3">
                <div class="w-100 d-flex flex-column align-items-center h-100 justify-content-between">
                    <div
                        class="w-100 h-100 mt-1 d-flex flex-column align-items-center pd-3 box-shadow justify-content-center">
                        <i class="bi bi-card-checklist h6 text-secondary "></i>
                        <div class="h6 text-center text-primary">
                            Test Cases
                        </div>
                        <div class="text-center h2 text-light">
                            20
                        </div>
                    </div>
                    <div
                        class="w-100 h-100 mt-1 d-flex flex-column align-items-center pd-3 box-shadow justify-content-center">
                        <i class="bi bi-bug h6 text-secondary "></i>
                        <div class=" h6 text-center text-primary">
                            Issues
                        </div>
                        <div class="text-center h2 text-light">
                            20
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="col-12 col-lg-4 top-stats box-shadow">
                <div class="row">
                    <div class="col-12 text-light ">Activity Feed</div>
                </div>
                <ul class="row list-unstyled overflow-y-scroll h-75 scroll-none mt-5">
                    <li class="p-1 mt-1 pointer text-secondary box-shadow d-flex flex-row justify-content-between " style="height: 2.4rem">
                        <small class="p-0 overflow-x-hidden ellipsis w-75">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo nihil magni asperiores
                        </small>
                        <small class="m-0 p-0">23:05pm</small>
                    </li>
                </ul>

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
                colors: ['#5C8374', '#ff0000'],
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
                },
                colors: ['#5C8374'],
                stroke: {
                    curve: 'smooth',
                }
            },
            Barseries: [{
                name: 'Test Cases',
                data: [30, 40, 45, 50, 49]
            }]
        }
    }
}
</script>
<style>
.top-stats {
    min-height: 35vh !important;
}

.box-shadow {
    box-shadow: 3px 5px 30px rgba(0, 0, 0, 0.5) !important;
}

.ellipsis {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.pointer {
    cursor: pointer;
}

.scroll-none::-webkit-scrollbar {
    display: none !important;
}
</style>