<template>
    <div>
        <apexchart ref="chart" :options="chartOptions" :series="chartData" height="300"></apexchart>
    </div>
</template>

<script>

import VueApexCharts from "vue3-apexcharts";

export default {

    components: {
        apexchart: VueApexCharts
    },

    data() {
        return {
            chartOptions: {
                chart: {
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        ndingShape: 'rounded',
                    },
                },
                xaxis: {
                    categories: [],
                },
                colors: ['#5C6BC0'],
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            if (value >= 1000000) {
                                return (value / 1000000).toFixed(1) + 'M';
                            } else if (value >= 1000) {
                                return (value / 1000).toFixed(0) + 'K';
                            } else {
                                return value;
                            }
                        },
                    },
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (value) {
                        const formatter = new Intl.NumberFormat('es-PE', {
                            style: 'currency',
                            currency: 'PEN',
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });
                        return formatter.format(value).replace(/\s/g, '');
                    },
                },
            },
            chartData: [
                {
                    name: 'Total',
                    data: [],
                },
            ],
        }
    },

    async mounted() {
        await this.fetchTopData();
    },

    methods: {
        async fetchTopData() {
            try {
                const response = await axios.get('/api/dashboard/top');
                const data = response.data;

                this.chartOptions.xaxis.categories = data.map(item => item.person);
                this.chartData[0].data = data.map(item => item.total);


                this.$refs.chart.updateOptions(this.chartOptions);

            } catch (error) {
                console.error('Error fetching data:', error);
            }
        },
    },
}
</script>
