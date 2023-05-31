<template>
    <div>
        <apexchart ref="chart" :options="chartOptions" :series="chartData" height="250"></apexchart>
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
                    animations: {
                        enabled: true,
                        easing: 'easeOutCubic',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        ndingShape: 'rounded',
                        columnWidth: '50%',
                    },
                },
                xaxis: {
                    categories: [],
                },
                colors: ['#727cf5'],
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
                    style: {
                        fontSize: '11px',
                    },
                    formatter: function (value) {
                        const formatter = new Intl.NumberFormat('es-PE', {
                            style: 'currency',
                            currency: 'PEN',
                            minimumFractionDigits: 1,
                            maximumFractionDigits: 1,
                        });

                        if (Math.abs(value) >= 1000) {
                            const suffixes = ['', 'K', 'M', 'B', 'T'];
                            const tier = Math.floor(Math.log10(Math.abs(value)) / 3);
                            const suffix = suffixes[tier];
                            const scaled = value / Math.pow(10, tier * 3);
                            return formatter.format(scaled) + suffix;
                        } else {
                            return formatter.format(value);
                        }
                    },
                },
                theme: {
                    palette: 'palette2'
                }
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
        await this.fetchChartData();
    },

    methods: {
        async fetchChartData() {
            try {
                const response = await axios.get('/api/dashboard/chart-data');
                const data = response.data;

                this.chartData[0].data = data.map(item => item.total);
                this.$refs.chart.updateSeries(this.chartData);

                this.chartOptions.xaxis.categories = data.map(item => item.description);
                this.$refs.chart.updateOptions(this.chartOptions);

            } catch (error) {
                console.error('Error fetching chart data:', error);
            }
        },
    },
}
</script>
