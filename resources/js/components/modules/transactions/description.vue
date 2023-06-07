<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">{{ this.description }}</a></li>
                            <li class="breadcrumb-item active">Listado de Transacciones</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Yape! {{ this.description }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Formulario de filtro -->
        <form class="row g-1 mb-2" @submit.prevent="fetchData">
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-primary border-primary text-white">
                        <small>Mostrar</small>
                    </span>
                    <select id="perPage" v-model="paginated.perPage" class="form-select"
                        @change="changeItemsPerPage(paginated.perPage)" aria-label="Mostrar resultados por página">
                        <option :value="10">10</option>
                        <option :value="20">20</option>
                        <option :value="50">50</option>
                        <option :value="100">100</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
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
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-primary border-primary text-white">
                        <small>Persona</small>
                    </span>
                    <input type="text" class="form-control" v-model="filter.person" @input="fetchData"
                        aria-label="Filtrar por persona">
                </div>
            </div>
            <div class="col-md-1 d-sm-grid">
                <button type="button" class="btn btn-primary d-block" @click.prevent="reset">
                    <i class="mdi mdi-refresh"></i>
                    Reset
                </button>
            </div>
            <div class="col-md-1 d-sm-grid">
                <button type="button" @click.prevent="openModalPendings" class="btn btn-warning d-block"
                    data-bs-toggle="modal" data-bs-target="#searchModal">
                    <i class="uil-search"></i>
                    Pdtes
                </button>
            </div>
        </form>

        <!-- Tabla de resultados -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" v-if="items.length > 0">
                        <div class="table-responsive-sm">
                            <table class="table table-centered table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th @click="toggleSort('description')">
                                            <span>Yape!</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('description')"></i>
                                        </th>
                                        <th @click="toggleSort('created_at')">
                                            <span>Registrado:</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('created_at')"></i>
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
                                    <tr v-for="transaction in items" :key="transaction.id"
                                        :class="{ 'bg-success-lighten': selectedRow === transaction.id }">
                                        <td>{{ transaction.description }}</td>
                                        <td>{{ transaction.formatted_date }}</td>
                                        <td>
                                            {{ transaction.person }}
                                            <span class="mdi mdi-content-copy text-muted"
                                                @click="copyToClipboard(transaction.person)" style="cursor:pointer;"
                                                aria-label="Copiar nombre de persona">&nbsp;</span>
                                        </td>
                                        <td>{{ transaction.amount }}</td>
                                        <td class="table-action">
                                            <button class="btn btn-sm font-11"
                                                :class="transaction.state === 'validated' ? 'btn-light text-muted' : 'btn-success'"
                                                :disabled="transaction.state === 'validated'"
                                                @click="confirmToggleStatus(transaction)">
                                                {{ transaction.state === 'validated' ? 'Validado' : 'Validar' }}
                                                <template v-if="transaction.state === 'validated'">
                                                    <i class="mdi mdi-lock"></i>
                                                </template>
                                                <template v-else>
                                                    <i class="mdi mdi-lock-open"></i>
                                                </template>
                                            </button>
                                        </td>
                                        <td>
                                            <span v-if="transaction.state === 'validated'">
                                                <i class="mdi mdi-circle text-success"></i> Validado
                                            </span>
                                            <span v-else>
                                                <i class="mdi mdi-circle text-warning"></i> Pendiente
                                            </span>
                                        </td>
                                        <td class="table-action text-center">
                                            <button type="button"
                                                :class="['btn', 'btn-sm', transaction.details ? 'btn-warning' : 'btn-light']"
                                                data-bs-toggle="modal" data-bs-target="#transactionModal"
                                                @click="openModal(transaction)" :title="transaction.details">
                                                <template v-if="transaction.details">
                                                    <i class="mdi mdi-comment-check"></i>
                                                </template>
                                                <template v-else>
                                                    <i class="mdi mdi-comment-outline"></i>
                                                </template>
                                            </button>
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

        <!-- Modal Details-->
        <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-success">
                        <h5 class="modal-title" id="transactionModalLabel">Detalles de Transacción</h5>
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

        <!-- Modal Pendientes -->
        <div class="modal fade" id="searchModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-warning">
                        <h5 class="modal-title">Buscar transacciones pendientes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="searchPendingTransactions">
                            <div class="mb-3">
                                <label>Persona</label>
                                <input v-model="searchPending.person" type="text"
                                    :class="['form-control', errors.person ? 'is-invalid' : '']" />
                                <span v-if="errors.person" class="invalid-feedback" role="alert">
                                    {{ errors.person }}
                                </span>
                            </div>
                            <div class="mb-3">
                                <label>Monto</label>
                                <input v-model="searchPending.amount" type="number"
                                    :class="['form-control', errors.amount ? 'is-invalid' : '']" />
                                <span v-if="errors.amount" class="invalid-feedback" role="alert">
                                    {{ errors.amount }}
                                </span>
                            </div>
                            <div class="mb-3">
                                <label>Fecha</label>
                                <input v-model="searchPending.register_date" type="date"
                                    :class="['form-control', errors.register_date ? 'is-invalid' : '']" />
                                <span v-if="errors.register_date" class="invalid-feedback" role="alert">
                                    {{ errors.register_date }}
                                </span>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary d-grid btn-block">Buscar</button>
                            </div>
                        </form>
                        <div class="mt-3">
                            <div v-if="isLoading" class="d-flex align-items-center">
                                <strong>Cargando...</strong>
                                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                            </div>
                            <div class="table-pendings" v-else>
                                <table class="table table-active table-sm table-nowrap table-centered">
                                    <tbody>
                                        <tr v-for="transaction in pendings">
                                            <td>
                                                <h5 class="font-13 mb-1 fw-normal">{{ transaction.person }}</h5>
                                                <span class="text-muted font-12">{{ transaction.register_date }}</span>
                                            </td>
                                            <td>
                                                <span class="text-success font-15 fw-bold pe-2">S/
                                                    {{ transaction.amount }}</span>
                                            </td>
                                            <td class="table-action text-center">
                                                <button class="btn btn-sm"
                                                    :class="transaction.state === 'validated' ? 'btn-light text-muted' : 'btn-success'"
                                                    :disabled="transaction.state === 'validated'"
                                                    @click="toggleStatus(transaction)">
                                                    {{ transaction.state === 'validated' ? 'Validado' : 'Validar' }}
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import dataMixin from "../mixins/dataMixin.js";
import toastMixin from "../mixins/toastMixin.js";

export default {

    mixins: [dataMixin, toastMixin],

    props: ['user', 'description', 'apiUrl'],

    data() {
        return {
            filter: {
                description: '',
                state: '',
                person: '',
            },
            paginated: {
                perPage: 100,
            },
            searchPending: {
                person: '',
                amount: '',
                register_date: '',
            },
            selectedTransaction: {},
            updateInterval: null,
            selectedRow: null,
            pendings: {},
            isLoading: false,
            errors: {
                person: '',
                amount: '',
                register_date: ''
            }

        }
    },

    mounted() {

        this.fetchData();

        this.updateInterval = setInterval(() => {
            this.fetchData();
        }, 5000);

    },

    beforeUnmount() {
        clearInterval(this.updateInterval);
    },

    watch: {
        description: {
            handler: function (newVal, oldVal) {
                if (newVal !== oldVal) {
                    this.fetchData(true);
                }
            },
            immediate: false,
            deep: false
        },
        apiUrl: {
            handler: function (newVal, oldVal) {
                if (newVal !== oldVal) {
                    this.fetchData(true);
                }
            },
            immediate: false,
            deep: false
        }
    },

    methods: {

        fetchData(resetPagination = false) {
            this.loadData(this.apiUrl, resetPagination);
        },

        getFilterParams() {
            return {
                person: this.filter.person,
                state: this.filter.state,
                page: this.paginated.page,
                perPage: this.paginated.perPage,
            };
        },

        confirmToggleStatus(transaction) {
            if (transaction.state === 'validated') {
                this.selectedRow = null;
                return;
            }

            this.selectedRow = transaction.id;

            this.$swal({
                title: '¿Cambiar a estado: Validado?',
                html: `<div class='p-3 bg-success-lighten m-2 font-18 rounded-3'>
                    ${transaction.person} por S/${transaction.amount}</br>
                    Fecha: ${transaction.formatted_date}
                </div>`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#727cf5',
                cancelButtonColor: '#fa5c7c',
                confirmButtonText: '¡Sí, Validar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.toggleStatus(transaction);
                }
                this.selectedRow = null;
            });
        },

        toggleStatus(transaction) {
            if (transaction.state !== 'validated') {
                transaction.state = 'validated';

                axios.put(`/admin/transactions/${transaction.id}/state`, {
                    state: transaction.state,
                    id: this.user.id
                }).then(response => {
                    this.showToast("¡Actualizado con éxito!", { type: "success" });
                    this.fetchData();
                }).catch(error => {
                    console.error(error);
                    this.$swal('¡Error!', 'Hubo un problema al actualizar el estado de la transacción.', 'error');
                });
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
            this.showToast("Texto copiado al portapapeles: " + text);

        },

        changeItemsPerPage(newPerPage) {
            this.paginated.perPage = newPerPage;
            this.fetchData(true);
        },

        openModal(transaction) {
            this.selectedTransaction = JSON.parse(JSON.stringify(transaction));
        },

        async updateDetails() {
            try {

                if (!this.selectedTransaction.details) {
                    console.log("No se ha ingresado ningún dato");
                    this.closeModal();
                    return
                }

                await axios.put(`/admin/transactions/${this.selectedTransaction.id}/details`, {
                    details: this.selectedTransaction.details,
                    id: this.user.id
                });

                this.showToast("Success, Actualizado!", {
                    type: "success"
                });

                this.closeModal();

            } catch (error) {
                console.error('Error al actualizar los detalles de la transacción:', error);
            }
        },

        reset() {
            this.filter = {
                state: '',
                person: ''
            };
            this.fetchData();
        },

        searchPendingTransactions() {
            this.isLoading = true;
            this.errors = {};
            axios.get('/admin/transactions/pendings', {
                params: {
                    person: this.searchPending.person,
                    amount: this.searchPending.amount,
                    register_date: this.searchPending.register_date,
                    description: this.description
                }
            })
                .then(response => {

                    this.pendings = response.data;

                    if (this.pendings && this.pendings.length > 0) {
                        this.showToast('Success', {
                            type: "success",
                            position: "top-center",
                            theme: 'colored',
                        });
                    } else {
                        this.showToast('No se encontraron resultados', {
                            type: "error",
                            position: "top-center",
                            theme: 'colored',
                        });
                    }
                })
                .catch(error => {
                    console.error(error);
                    if (error.response && error.response.status === 422) {
                        this.isLoading = false

                        this.showToast(error.response.data.message, {
                            type: "error",
                            position: "top-center",
                            theme: 'colored',

                        });

                        const errors = error.response.data.errors;
                        this.errors.person = errors.person ? errors.person[0] : false;
                        this.errors.amount = errors.amount ? errors.amount[0] : false;
                        this.errors.register_date = errors.register_date ? errors.register_date[0] : false;

                        console.log(errors)

                    } else {
                        console.error(error);
                        this.isLoading = false
                    }
                }).finally(() => {
                    this.isLoading = false;
                });
        },

        openModalPendings() {
            this.searchPending = {
                person: '',
                amount: '',
                register_date: '',
            };
            this.pendings = {}
        },

        closeModal() {
            const modalElement = document.getElementById('transactionModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
        },
    }

};
</script>

<style></style>
