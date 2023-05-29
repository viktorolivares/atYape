<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Transacciones</a></li>
                            <li class="breadcrumb-item active">Listado de Transacciones</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Transacciones</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <!-- Formulario de filtro -->
        <div>
            <form class="row g-1 mb-1" @submit.prevent="fetchData">
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-text bg-primary border-primary text-white">
                            <small>Estado</small>
                        </span>
                        <select id="state" v-model="filter.state" class="form-select" @change="fetchData"
                            aria-label="Filtrar por estado">
                            <option :value="''">Todos</option>
                            <option :value="'validated'">Validados</option>
                            <option :value="'pending'">Pendientes</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-text bg-primary border-primary text-white">
                            <small>Yape!</small>
                        </span>
                        <select id="description" v-model="filter.description" class="form-select" @change="fetchData"
                            aria-label="Filtrar por Yape">
                            <option :value="''">Todos</option>
                            <option :value="'Business'">Business</option>
                            <option :value="'Mulfood'">Mulfood</option>
                            <option :value="'Televentas'">Televentas</option>
                            <option :value="'Teleservicios'">Teleservicios</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-primary border-primary text-white">
                            <small>Desde</small>
                        </span>
                        <input type="datetime-local" class="form-control" id="startDate" v-model="filter.startDate"
                            aria-label="Filtrar por fecha de inicio">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-primary border-primary text-white">
                            <small>Hasta</small>
                        </span>
                        <input type="datetime-local" class="form-control" id="endDate" v-model="filter.endDate"
                            aria-label="Filtrar por fecha de fin">
                    </div>
                </div>
                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn btn-success" aria-label="Buscar transacciones">
                        <i class="uil-search"></i>
                    </button>
                </div>
                <div class="col-md-1 d-grid">
                    <template v-if="getPermissions.includes('transactions.create')">
                        <button class="btn btn-primary" aria-label="Agregar transaccioón"
                            @click.prevent="openModalTransaction" data-bs-toggle="modal"
                            data-bs-target="#transactionSaveModal">
                            <i class=" uil-plus"></i>
                        </button>
                    </template>
                    <template v-else>
                        <button class="btn btn-danger" disabled>
                            <i class="mdi mdi-block-helper"></i>
                        </button>
                    </template>
                </div>
            </form>
        </div>
        <!-- Tabla de resultados -->
        <div class="row">
            <div class="col-md-12 mt-1">
                <div class="card">
                    <div class="mt-3 mx-3">
                        <div class="row justify-content-between">
                            <div class="col-2">
                                <div class="input-group">
                                    <span class="input-group-text bg-primary border-primary text-white">
                                        <small>Mostrar</small>
                                    </span>
                                    <select id="perPage" v-model="paginated.perPage" class="form-select form-select-sm"
                                        @change="changeItemsPerPage(paginated.perPage)"
                                        aria-label="Mostrar resultados por página">
                                        <option :value="10">10</option>
                                        <option :value="20">20</option>
                                        <option :value="50">50</option>
                                        <option :value="100">100</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-primary border-primary text-white">
                                        <small>Persona</small>
                                    </span>
                                    <input type="text" class="form-control" v-model="filter.person" @input="fetchData"
                                        aria-label="Filtrar por persona">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-fixed-header" v-if="items.length > 0">
                        <div class="table-responsive-sm">
                            <table class="table table-centered table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th @click="toggleSort('description')">
                                            <span>Yape!</span>
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
                                        <th>Actualizar</th>
                                        <th @click="toggleSort('state')">
                                            <span>Estado</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('state')"></i>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <transition-group name="fade" tag="tbody" mode="in-out">
                                    <tr v-for="transaction in items" :key="transaction.id">
                                        <td>{{ transaction.description }}</td>
                                        <td>
                                            {{ transaction.person }}
                                            <span class="mdi mdi-content-copy text-muted"
                                                @click="copyToClipboard(transaction.person)" style="cursor:pointer;"
                                                aria-label="Copiar nombre de persona">&nbsp;</span>
                                        </td>
                                        <td>{{ transaction.amount }}</td>
                                        <td>{{ transaction.formatted_date }}</td>
                                        <td class="table-action text-center">
                                            <template v-if="getPermissions.includes('transactions.edit')">
                                                <label class="switch" aria-label="Cambiar estado">
                                                    <input type="checkbox" :checked="transaction.state === 'validated'"
                                                        @change="toggleStatus(transaction)"
                                                        aria-checked="transaction.state === 'validated'" />
                                                    <span class="slider round"></span>
                                                </label>
                                            </template>
                                            <template v-else>
                                                <button href="#" class="btn btn-sm" disabled>
                                                    <i class="mdi mdi-block-helper"></i>
                                                </button>
                                            </template>
                                        </td>
                                        <td>
                                            <span v-if="transaction.state === 'validated'">
                                                <i class="mdi mdi-circle text-success"></i> Validado
                                            </span>
                                            <span v-else>
                                                <i class="mdi mdi-circle text-warning"></i> Pendiente
                                            </span>
                                        </td>
                                        <td class="table-action text-center" v-if="transaction.system == 'Web'">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="mdi mdi-menu"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <template v-if="getPermissions.includes('transactions.edit')">
                                                        <a type="button" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#transactionSaveModal"
                                                            @click="openModalEdit(transaction)">
                                                            <i class="mdi mdi-lead-pencil"></i>
                                                            Editar
                                                        </a>
                                                        <a type="button" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#transactionDetailsModal"
                                                            @click="openModalDetails(transaction)"
                                                            :title="transaction.details">
                                                            <i class="mdi mdi-comment-text-outline"></i>
                                                            Detalles
                                                        </a>
                                                    </template>
                                                    <template v-else>
                                                        <button href="#" class="btn btn-sm" disabled>
                                                            <i class="mdi mdi-block-helper"></i>
                                                            Can't edit
                                                        </button>
                                                    </template>
                                                    <template v-if="getPermissions.includes('transactions.delete')">
                                                        <a type="button" class="dropdown-item"
                                                            @click="deleteTransaction(transaction)">
                                                            <i class="mdi mdi-delete"></i>
                                                            Eliminar
                                                        </a>
                                                    </template>
                                                    <template v-else>
                                                        <button href="#" class="btn btn-sm" disabled>
                                                            <i class="mdi mdi-block-helper"></i>
                                                            Can't delete
                                                        </button>
                                                    </template>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="table-action text-center" v-else>
                                            <a type="button" class="btn btn-sm btn-light" data-bs-toggle="modal"
                                                data-bs-target="#transactionDetailsModal"
                                                @click="openModalDetails(transaction)" :title="transaction.details">
                                                <i class="mdi mdi-comment-text-outline"></i>
                                            </a>
                                        </td>
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
        <!-- Modal Details -->
        <div class="modal" id="transactionDetailsModal" tabindex="-1" aria-labelledby="transactionDetailsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-success">
                        <h5 class="modal-title" id="transactionDetailsModalLabel">Detalles de Transacción</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea class="form-control" id="transactionDetails"
                                v-model="selectedTransaction.details"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success" @click="updateDetails(transaction)">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Transaction -->
        <div class="modal" id="transactionSaveModal" tabindex="-1" aria-labelledby="transactionSaveModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-primary">
                        <h5 class="modal-title" id="transactionSaveModalLabel">Guardar Transacción</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="saveTransaction">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="register_date" class="form-label">Fecha de Registro</label>
                                <input type="datetime-local" class="form-control" id="register_date"
                                    v-model="transactionData.register_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Yape!</label>
                                <select id="description" v-model="transactionData.description" class="form-select" required>
                                    <option :value="''" disabled>Seleccionar</option>
                                    <option :value="'Business'">Business</option>
                                    <option :value="'Mulfood'">Mulfood</option>
                                    <option :value="'Televentas'">Televentas</option>
                                    <option :value="'Teleservicios'">Teleservicios</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="person" class="form-label">Persona</label>
                                <input type="text" class="form-control" id="person" v-model="transactionData.person"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Monto</label>
                                <input type="number" class="form-control" id="amount" v-model="transactionData.amount"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import { format, subDays } from 'date-fns';
import dataMixin from "../mixins/dataMixin.js";
import toastMixin from "../mixins/toastMixin.js";

export default {

    mixins: [dataMixin, toastMixin],

    props: ['user'],

    data() {
        return {
            apiUrl: "/api/transactions/list",
            selectedTransaction: {},
            updateInterval: null,
            filter: {
                description: '',
                state: '',
                person: '',
            },
            paginated: {
                perPage: 100,
            },
            transactionData: {
                register_date: '',
                description: '',
                person: '',
                amount: '',
            },
            getPermissions: JSON.parse(localStorage.getItem('permissions'))
        }
    },

    mounted() {

        this.fetchData();
        this.setDefaultDates();

        this.updateInterval = setInterval(() => {
            this.fetchData();
        }, 5000);

    },

    beforeUnmount() {
        clearInterval(this.updateInterval);
    },

    methods: {

        fetchData(resetPagination = false) {
            this.loadData(this.apiUrl, resetPagination);
        },

        getFilterParams() {
            return {
                startDate: this.filter.startDate,
                endDate: this.filter.endDate,
                description: this.filter.description,
                person: this.filter.person,
                state: this.filter.state,
                page: this.paginated.page,
                perPage: this.paginated.perPage,
            };
        },

        setDefaultDates() {

            const endDate = new Date();
            const startDate = subDays(endDate, 7);


            endDate.setDate(endDate.getDate() + 1);
            endDate.setHours(0, 0, 0, 0);

            this.filter.startDate = format(startDate, 'yyyy-MM-dd hh:mm');
            this.filter.endDate = format(endDate, 'yyyy-MM-dd HH:mm');
        },

        async toggleStatus(transaction) {

            const state = transaction.state === 'validated' ? 'pending' : 'validated';
            try {
                await axios.put(`/api/transactions/${transaction.id}/state`, {
                    state: state,
                    id: this.user.id
                });

                transaction.state = state;

                this.showToast("Success, Actualizado!", {
                    type: "success"
                });

            } catch (error) {
                console.error('Error al actualizar el estado de la transacción:', error);
            }
        },

        async updateDetails() {
            try {
                if (!this.selectedTransaction.details) {
                    console.log("No se ha ingresado ningún dato");
                    this.closeModalDetails();
                    return
                }

                await axios.put(`/api/transactions/${this.selectedTransaction.id}/details`, {
                    details: this.selectedTransaction.details,
                    id: this.user.id
                });

                this.showToast("Success, Actualizado!", {
                    type: "success"
                });

                this.closeModalDetails();

            } catch (error) {
                console.error('Error al actualizar los detalles de la transacción:', error);
            }
        },

        copyToClipboard(text) {
            const el = document.createElement('textarea');
            el.value = text;
            el.setAttribute('readonly', '');
            el.style.position = 'absolute';
            el.style.left = '-9999px';
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            this.showToast("Texto copiado: " + text, {
                type: "info"
            });

        },

        changeItemsPerPage(newPerPage) {
            this.paginated.perPage = newPerPage;
            this.fetchData(true);
        },

        openModalDetails(transaction) {
            this.selectedTransaction = JSON.parse(JSON.stringify(transaction));
        },

        openModalTransaction() {
            this.transactionData = {
                register_date: '',
                description: '',
                person: '',
                amount: ''
            };
        },

        saveTransaction() {

            const url = this.transactionData.id ? `/api/transactions/update/${this.transactionData.id}` : '/api/transactions/save';
            const method = this.transactionData.id ? 'put' : 'post';

            axios({ method, url, data: this.transactionData })
                .then(response => {
                    console.log(response.data);
                    if (response.data.success === true) {
                        this.showToast("Se guardó la transacción", {
                            type: "success"
                        });
                        this.fetchData();
                        this.transactionData = {};
                    }
                })
                .catch(error => {
                    console.log(error)
                });

            this.closeModalTransaction();
        },

        deleteTransaction(transaction) {
            this.$swal({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#727cf5',
                cancelButtonColor: '#fa5c7c',
                confirmButtonText: '¡Sí, bórralo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/transactions/delete/${transaction.id}`)
                        .then(response => {
                            this.fetchData();
                            this.$swal('¡Eliminado!', 'La transacción ha sido eliminada.', 'success');
                        })
                        .catch(error => {
                            console.error(error);
                            this.$swal('¡Error!', 'Hubo un problema al eliminar la transacción.', 'error');
                        });
                }
            });
        },

        openModalEdit(transaction) {
            this.transactionData = JSON.parse(JSON.stringify(transaction));
            this.transactionData.register_date = format(new Date(this.transactionData.register_date), 'yyyy-MM-dd\'T\'HH:mm');
        },

        closeModalDetails() {
            const modalElement = document.getElementById('transactionDetailsModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
        },

        closeModalTransaction() {
            const modalElement = document.getElementById('transactionSaveModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
        }
    }
};

</script>
