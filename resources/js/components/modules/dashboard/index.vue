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
                            <a href="#" class="btn btn-primary ms-2" @click="getData">
                                <i class="uil-search"></i>
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
                                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">
                                            {{ item.description }}
                                        </h5>
                                        <h3 class="mt-3 mb-3">{{ formatCurrency(item.total) }}</h3>
                                        <p class="mb-0 text-muted">
                                            <span class="me-2" :class="{
                                                'text-success': ratio[item.description] >= 0,
                                                'text-danger': ratio[item.description] < 0,
                                            }">
                                                <i class="mdi" :class="{
                                                        'mdi-arrow-up-bold': ratio[item.description] >= 0,
                                                        'mdi-arrow-down-bold': ratio[item.description] < 0,
                                                    }">
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
                    <div class="col-lg-5">
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
                    <div class="col-lg-2">
                        <div class="card">
                            <div class="card-body" v-if="totalTransactions !== 0">
                                <h5 class="header-title mt-1 mb-3">Transacciones:</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm table-centered mb-0 font-14">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span class="text-muted">Validadas</span>
                                                    <h2>
                                                        {{ totalValidatedTransactions }}
                                                    </h2>
                                                    <div class="progress mb-3">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                                            :style="{ width: (totalValidatedTransactions / totalTransactions * 100) + '%' }"
                                                            aria-valuenow="summary.totalValidatedTransactions"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            {{ (totalValidatedTransactions / totalTransactions * 100).toFixed(0) }}%
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="text-muted">Pendientes:</span>
                                                    <h2>
                                                        {{ totalPendingTransactions }}
                                                    </h2>
                                                    <div class="progress mb-3">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar"
                                                            :style="{ width: ((totalTransactions - totalValidatedTransactions) / totalTransactions * 100) + '%' }"
                                                            aria-valuenow="(summary.totalTransactions - summary.totalValidatedTransactions)"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            {{ ((totalTransactions - totalValidatedTransactions) / totalTransactions * 100).toFixed(0) }}%
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                            <div class="card-body" v-else >
                                <span class="text-muted">SIN DATOS</span>
                            </div>
                            <!-- end card-body-->
                        </div>
                        <!-- end card-->
                    </div>
                    <!-- end col-->
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
            totalTransactions: 0,
            totalValidatedTransactions: 0,
            totalPendingTransactions: 0,
        }
    },

    async mounted() {
        const date = new Date();
        this.date = moment(date).format("YYYY-MM-DD");
        this.fetchDataForSelectedDate();
        this.getTransactionStates();

    },

    methods: {

        getData() {
            this.fetchDataForSelectedDate();
            this.getTransactionStates();
        },

        fetchDataForSelectedDate() {
            axios
                .get("/admin/dashboard/data", { params: { date: this.date } })
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
        },

        async getTransactionStates() {
            try {
                const response = await axios.get("/admin/dashboard/state-day", { params: { date: this.date } });
                const summary = response.data;

                this.totalValidatedTransactions = summary.totalValidatedTransactions;
                this.totalPendingTransactions = summary.totalPendingTransactions;
                this.totalTransactions = summary.totalTransactions;

                console.log(this.totalTransactions)

                console.log(response)
            } catch (error) {
                console.error("Error fetching transaction states:", error);
            }
        },
    },
};

</script>
