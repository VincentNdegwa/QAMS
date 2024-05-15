<template>
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="p text-center text-primary">Testcases in projects</div>
            <apexchart
                type="bar"
                :options="TestCasechartOptions"
                :series="TestCasechartSeries"
            />
        </div>
        <div class="col-12 col-lg-6">
            <div class="p text-center text-primary">
                Projects in organisation
            </div>
            <apexchart
                type="area"
                :options="ProjectchartOptions"
                :series="ProjectchartSeries"
            />
        </div>
    </div>
</template>
<script>
export default {
    props: {
        testcaseProject: {
            type: Array,
        },
        projectOrganisation: {
            type: Array,
            default: [],
        },
    },
    data() {
        return {
            ProjectchartOptions: {
                chart: {
                    id: "basic-line-chart",
                    toolbar: {
                        show: false,
                    },
                },
                xaxis: {
                    categories: this.projectOrganisation?.map(
                        (item) => item.name
                    ),
                },
                grid: {
                    show: false,
                },
                colors: ["#EC7A08"],
                stroke: {
                    curve: "smooth",
                },
            },
            ProjectchartSeries: [
                {
                    name: "Projects",
                    data: this.projectOrganisation?.map(
                        (item) => item.project_count
                    ),
                },
            ],
            TestCasechartOptions: {
                chart: {
                    id: "basic-line-chart",
                    toolbar: {
                        show: false,
                    },
                },
                xaxis: {
                    categories: this.testcaseProject?.map((item) => item.name),
                },
                grid: {
                    show: false,
                },
                colors: ["#F0AB00"],
                stroke: {
                    curve: "smooth",
                },
            },
            TestCasechartSeries: [
                {
                    name: "TestCases",
                    data: this.testcaseProject?.map((item) => item.test_count),
                },
            ],
        };
    },
};
</script>
