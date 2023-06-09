<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Reportes</a></li>
                            <li class="breadcrumb-item active">Consulta de Transacciones</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Reportes</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <!-- Formulario de filtro -->
        <form @submit.prevent="fetchData">
            <div class="card">
                <div class="card-header bg-info-lighten">
                    Filtros
                </div>
                <div class="card-body row g-2 mb-2">
                    <!-- Estado -->
                    <div class="col-sm-6 col-md-3">
                        <label for="state" class="form-label">Estado</label>
                        <select id="state" class="form-select" v-model="filter.state">
                            <option value="">Todos</option>
                            <option value="validated">Validados</option>
                            <option value="pending">Pendientes</option>
                        </select>
                    </div>
                    <!-- Yape! -->
                    <div class="col-sm-6 col-md-3">
                        <label for="description" class="form-label">Yape!</label>
                        <select id="description" class="form-select" v-model="filter.description">
                            <option value="">Todos</option>
                            <option value="Business">Business</option>
                            <option value="Mulfood">Mulfood</option>
                            <option value="Televentas">Televentas</option>
                            <option value="Teleservicios">Teleservicios</option>
                        </select>
                    </div>
                    <!-- Desde -->
                    <div class="col-sm-6 col-md-3">
                        <label for="startDate" class="form-label">Desde</label>
                        <input type="datetime-local" class="form-control" :class="{ 'is-invalid': errors.startDate }" v-model="filter.startDate">
                        <div class="invalid-feedback" v-if="errors.startDate">
                            {{ errors.startDate[0] }}
                        </div>
                    </div>
                    <!-- Hasta -->
                    <div class="col-sm-6 col-md-3">
                        <label for="endDate" class="form-label">Hasta</label>
                        <input type="datetime-local" class="form-control"  :class="{ 'is-invalid': errors.endDate }" v-model="filter.endDate">
                        <div class="invalid-feedback" v-if="errors.endDate">
                            {{ errors.endDate[0] }}
                        </div>
                    </div>
                    <!-- Persona -->
                    <div class="col-sm-6 col-md-3">
                        <label for="person" class="form-label">Persona</label>
                        <input type="text" class="form-control" id="person" v-model="filter.person">
                    </div>
                    <!-- Monto > a -->
                    <div class="col-sm-6 col-md-3">
                        <label for="amountGreater" class="form-label">Monto mayor que:</label>
                        <input type="number" class="form-control" :class="{ 'is-invalid': errors.amountGreater }" v-model="filter.amountGreater">
                        <div class="invalid-feedback" v-if="errors.amountGreater">
                            {{ errors.amountGreater[0] }}
                        </div>
                    </div>
                    <!-- Monto < a -->
                    <div class="col-sm-6 col-md-3">
                        <label for="amountLess" class="form-label">Monto menor que:</label>
                        <input type="number" class="form-control"  :class="{ 'is-invalid': errors.amountLess }" v-model="filter.amountLess">
                        <div class="invalid-feedback" v-if="errors.amountLess">
                            {{ errors.amountLess[0] }}
                        </div>
                    </div>
                    <!-- Botón de búsqueda -->
                    <div class="col-sm-6 col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100" :disabled="loading">
                            <span class=" uil-search"></span>
                            &nbsp;{{ loading ? 'Espere unos segundos' : 'Buscar'}}
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <!-- Tabla de resultados -->
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="card">
                    <div class="mt-3 mx-3">
                        <div class="row justify-content-between">

                            <div class="col-3">
                                <button class="btn btn-sm btn-success" @click="fetchAllData">
                                    <i class="mdi mdi-file-excel"></i>
                                    &nbsp; Exportar
                                </button>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-primary border-primary text-white">
                                        <small>Mostrar</small>
                                    </span>
                                    <select id="perPage" v-model="paginated.perPage" class="form-select form-select-sm"
                                        @change="changeItemsPerPage(paginated.perPage)"
                                        aria-label="Mostrar resultados por página">
                                        <option :value="5">5</option>
                                        <option :value="10">10</option>
                                        <option :value="20">20</option>
                                        <option :value="50">50</option>
                                        <option :value="100">100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" v-if="items.length > 0">
                        <div class="table-responsive-sm">
                            <table class="table table-centered table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th @click="toggleSort('description')">
                                            <span>Yape</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('description')"></i>
                                        </th>
                                        <th @click="toggleSort('person')">
                                            <span>Persona</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('person')"></i>
                                        </th>
                                        <th @click="toggleSort('amount')">
                                            <span>Monto</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('amount')"></i>
                                        </th>
                                        <th @click="toggleSort('created_at')">
                                            <span>Registrado:</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('created_at')"></i>
                                        </th>
                                        <th @click="toggleSort('state')">
                                            <span>Estado</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('state')"></i>
                                        </th>
                                        <th>Validado por:</th>
                                    </tr>
                                </thead>
                                <transition-group name="fade" tag="tbody" mode="in-out">
                                    <tr v-for="(transaction, index) in items" :key="transaction.id">
                                        <td>{{ index + 1 }}</td>
                                        <td> {{ transaction.description }} </td>
                                        <td> {{ transaction.person }} </td>
                                        <td>{{ transaction.amount }}</td>
                                        <td>{{ transaction.formatted_date }}</td>
                                        <td>
                                            <span>
                                                <i class="mdi mdi-circle"
                                                    :class="[transaction.state === 'validated' ? 'text-success' : 'text-warning']"></i>
                                                {{ transaction.state === 'validated' ? 'Validado' : 'Pendiente' }}
                                            </span>
                                        </td>
                                        <td><i class="text-info">{{ transaction.updated_by.email }}</i></td>
                                    </tr>
                                </transition-group>
                            </table>
                        </div>
                        <nav class="mt-4">
                            <ul class="pagination pagination-rounded mb-0">
                                <li class="page-item" :class="{ disabled: paginated.page === 1 }">
                                    <a class="page-link" href="#" @click.prevent="goToFirstPage()"
                                        aria-label="Ir a la primera página">
                                        <i class="mdi mdi-chevron-double-left"></i>
                                    </a>
                                </li>
                                <li v-for="(pageData, index) in pagination" :key="index" class="page-item"
                                    :class="{ disabled: !pageData.url }, { active: pageData.active }">
                                    <a class="page-link" href="#" @click.prevent="goToPage(pageData.url)"
                                        aria-label="Ir a la página {{ pageData.label }}">
                                        <span v-html="pageData.label"></span>
                                    </a>
                                </li>
                                <li class="page-item" :class="{ disabled: paginated.page === paginated.totalPages }">
                                    <a class="page-link" href="#" @click.prevent="goToLastPage()"
                                        aria-label="Ir a la última página">
                                        <i class="mdi mdi-chevron-double-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <div class="my-2 justify-content-end" v-if="loading">
                            <span class="spinner-border spinner-border-sm text-primary" role="status"
                                aria-label="Cargando..."></span>
                            <span class="ms-2">Cargando...</span>
                        </div>
                        <div class="my-2 justify-content-end" v-else>
                            <small>Mostrando {{ paginated.page }} de {{ paginated.totalPages }}</small>
                        </div>
                    </div>
                    <div v-else>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 offset-md-4">
                                    <div class="alert alert-warning" role="alert">
                                        <i class="dripicons-warning me-2"></i>
                                        No existen registros...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import toastMixin from "../mixins/toastMixin.js";
import dataMixin from "../mixins/dataMixin.js";
import * as XLSX from 'xlsx'

export default {

    mixins: [dataMixin, toastMixin],

    data() {
        return {

            apiUrl: "/admin/reports/list",
            filter: {
                amountGreater: '',
                amountLess: '',
                description: '',
                startDate: '',
                endDate: '',
                person: '',
                state: '',
            },
            paginated: {
                perPage: 50,
            },
        }
    },

    mounted() {
        this.fetchData();
    },

    methods: {

        fetchData(resetPagination = false) {

            if (this.filter.startDate && this.filter.endDate) {
                const startDate = new Date(this.filter.startDate);
                const endDate = new Date(this.filter.endDate);

                const diffTime = Math.abs(endDate - startDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (diffDays > 31) {
                    this.showToast("El rango de fechas no puede exceder los 31 días", { type: "error" });
                    return;
                }
            }

            this.loadData(this.apiUrl, resetPagination);
        },

        fetchAllData() {
            axios.get('/admin/reports/export', { params: this.getFilterParams() })
                .then(response => {
                    this.exportToExcel(response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        },

        getFilterParams() {
            let params = {
                amountGreater : this.filter.amountGreater,
                description: this.filter.description,
                amountLess : this.filter.amountLess,
                startDate : this.filter.startDate,
                endDate : this.filter.endDate,
                person: this.filter.person,
                state: this.filter.state,
            };

            return params;
        },

        changeItemsPerPage(newPerPage) {
            this.paginated.perPage = newPerPage;
            this.fetchData(true);
        },

        exportToExcel(data) {

            const mappedData = data.map((transaction) => ({
                ID: transaction.transaction,
                Yape: transaction.description,
                Mensaje: transaction.message,
                Persona: transaction.person,
                System: transaction.system,
                Monto: transaction.amount,
                Estado: transaction.state  === 'validated' ? 'Validado' : 'Pendiente',
                Observaciones: transaction.details,
                Actualizado: transaction.updated_by.email,
                Registrado: transaction.formatted_date,
            }));

            const workbook = this.createWorkbook(mappedData);
            const OCTET_STREAM_TYPE = 'application/octet-stream';
            const excelData = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
            this.saveExcelFile(new Blob([excelData], { type: OCTET_STREAM_TYPE }), 'Report.xlsx');
        },

        saveExcelFile(buffer, fileName) {

            const EXCEL_TYPE = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

            const data = new Blob([buffer], { type: EXCEL_TYPE });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(data);
            link.download = fileName;
            link.click();
        },

        createWorkbook(data) {
            const worksheet = XLSX.utils.json_to_sheet(data);
            return { Sheets: { 'data': worksheet }, SheetNames: ['data'] };
        },

        getCurrentTime() {
            const now = new Date()
            const hours = now.getHours().toString().padStart(2, '0')
            const minutes = now.getMinutes().toString().padStart(2, '0')
            const seconds = now.getSeconds().toString().padStart(2, '0')
            return `${hours}${minutes}${seconds}`
        },

    }
}
</script>
