<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right d-flex">
                        <form class="d-flex">
                            <div class="input-group ms-2">
                                <span class="input-group-text bg-primary border-primary text-white">
                                    <small>Date</small>
                                </span>
                                <input type="date" class="form-control" v-model="date">
                            </div>
                            <a href="#" class="btn btn-sm btn-primary ms-2" @click="fetchDataForSelectedDate">
                                <i class="mdi mdi-search-web"></i>
                            </a>
                        </form>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="row">
                            <span v-if="data.length"></span>
                            <p v-else>Venta diaria | No hay datos disponibles para mostrar.</p>
                            <div class="col-md-6 col-xl-6 col-lg-6" v-for="(item, index) in data" :key="index">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="mdi mdi-chart-bar widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">{{ item.description }}</h5>
                                        <h3 class="mt-3 mb-3">{{ formatCurrency(item.total) }}</h3>
                                        <p class="mb-0 text-muted">
                                            <span
                                                class="me-2"
                                                :class="{
                                                    'text-success': ratio[item.description] >= 0,
                                                    'text-danger': ratio[item.description] < 0,
                                                }"
                                            >
                                                <i
                                                    class="mdi"
                                                    :class="{
                                                            'mdi-arrow-up-bold': ratio[item.description] >= 0,
                                                            'mdi-arrow-down-bold': ratio[item.description] < 0,
                                                        }"
                                                >
                                                </i>
                                            {{ Math.abs(ratio[item.description]).toFixed(2) }}%
                                            </span>
                                            <span class="text-nowrap">Desde ayer</span>
                                        </p>
                                    </div>
                                    <!-- end card-body-->
                                </div>
                                <!-- end card-->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title mb-3">ÚLTIMOS 30 DÍAS</h4>
                                <div dir="ltr">
                                    <Sales></Sales>
                                </div>
                            </div>
                            <!-- end card-body-->
                        </div>
                         <!-- end card-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title mb-3">CLIENTES | TOP 10</h4>
                                <Top></Top>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="header-title mb-3">VENTAS | ULTIMOS 15 DIAS</h4>
                                <SalesDay></SalesDay>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
    </div>
</template>

<script>

import SalesDay from "./sales-day.vue";
import Sales from "./sales.vue";
import Top from "./top.vue";

export default {

    components: {
        Sales, Top, SalesDay
    },

    data() {
        return {
            date: '',
            data: [],
            ratio: [],
        }
    },

    async mounted() {
        const date = new Date();
        this.date = moment(date).format("YYYY-MM-DD");
        this.fetchDataForSelectedDate();

    },

    methods: {

        fetchDataForSelectedDate() {
            axios
                .get("/api/dashboard/data", { params: { date: this.date } })
                .then((response) => {
                    this.data = response.data.data,
                    this.ratio = response.data.ratio
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        formatCurrency(value) {
            const formatter = new Intl.NumberFormat('es-PE', {
                style: 'currency',
                currency: 'PEN',
                minimumFractionDigits: 2,
            });
            return formatter.format(value);
        }
    },
};

</script>
