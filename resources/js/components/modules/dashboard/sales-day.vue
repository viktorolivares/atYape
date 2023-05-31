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
                    type: 'area',
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        ndingShape: 'rounded',
                    },
                },
                xaxis: {
                    categories: [],
                    type: 'datetime',
                    labels: {
                        formatter: function(value, timestamp) {
                            const date = new Date(value)
                            const options = {day: 'numeric', month: 'numeric', year: 'numeric'}
                            return date.toLocaleDateString('es-PE', options)
                        }
                    }

                },
                colors: ['#09b080'],
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
        await this.fetchData();
    },

    methods: {
        async fetchData() {
            try {
                const response = await axios.get("/admin/dashboard/sales-day");
                const data = response.data;

                this.chartOptions.xaxis.categories = data.map(item => item.date);
                this.chartData[0].data = data.map(item => item.total);

                this.$refs.chart.updateOptions(this.chartOptions);
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        }
    },
}
</script>
