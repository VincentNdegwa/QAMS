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
            <!-- <div class="col-12 col-lg-5 box-shadow">
                <div class="row">
                    <div class="col-12 text-light ">
                        Stages is Modules
                    </div>
                    <div class="col-12">
                        <apexchart type="area" :options="Baroptions" :series="Barseries"></apexchart>
                    </div>
                </div>
            </div> -->
            <!--  -->
            <div class="col-12 col-lg-4">
                <div class="w-100 d-flex flex-column align-items-center h-100 justify-content-between">
                    <div
                        class="w-100 h-100 mt-1 d-flex flex-column align-items-center pd-3 box-shadow justify-content-center">
                        <i class="bi bi-card-checklist h6 text-secondary "></i>
                        <div class="h6 text-center text-primary">
                            Test Cases
                        </div>
                        <div class="text-center h2 text-light">
                            {{ data.totalCases }}
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

            <div class="col-12 col-lg-8 top-stats box-shadow">
                <div class="row">
                    <ActivityFeed :activities="data.activities" />
                </div>
            </div>
        </div>
    </SingleProject>
</template>
<script>
import SingleProject from './Layouts/SingleProject.vue';
import ActivityFeed from "./components/DashComponents/ActivityFeed.vue"
export default {
    props: {
        data: {
            type: Array
        }
    },
    mounted() {
        console.log(this.data)
    },
    components: {
        SingleProject,
        ActivityFeed
    }, data() {
        return {
            series: [this.data.completedCases, this.data.totalCases - this.data.completedCases],
            options: {
                labels: ['Completed', 'Remaining'],
                responsive: [{
                    options: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                colors: ['#00FF00', '#FF0000'],
                stroke: {
                    color: null
                }

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
                    categories: this.data?.moduleCount?.map(item => item.module_name)
                },
                colors: ['#EC7A08'],
                stroke: {
                    curve: 'smooth',
                }
            },
            Barseries: [{
                name: 'Test Cases',
                data: this.data?.moduleCount?.map(item => item.test_count)
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