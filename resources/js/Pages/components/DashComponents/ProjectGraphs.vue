<template>
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="p text-center text-primary ">Testcases in projects</div>
            <apexchart type="bar" :options="chartOptions" :series="chartSeries" />
        </div>
        <div class="col-12 col-lg-6">
            <div class="p text-center text-primary ">Projects in organisation</div>
            <apexchart type="area" :options="chartOptions" :series="chartSeries" />
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            chartOptions: {
                chart: {
                    id: 'basic-line-chart',
                    toolbar: {
                        show: false
                    }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                },
                grid: {
                    show: false
                },
                colors: ['#5C8374'],
                stroke: {
                    curve: 'smooth',
                }
            },
            chartSeries: [
                {
                    name: 'Series 1',
                    data: [30, 40, 35, 50, 49, 60, 70, 91, 125],
                },
            ],
        }
    }
}
</script>