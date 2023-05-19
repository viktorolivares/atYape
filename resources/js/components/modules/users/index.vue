<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
                            <li class="breadcrumb-item active">Listado de Usuarios</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Usuarios</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        
        <!-- Formulario de filtro -->
        <form class="row g-1 mt-1" @submit.prevent="fetchData">
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-primary border-primary text-white">
                        <small>Mostrar</small>
                    </span>
                    <select id="perPage" v-model="paginated.perPage" class="form-select form-select-sm"
                        @change="changeItemsPerPage(paginated.perPage)" aria-label="Mostrar resultados por página">
                        <option :value="5">5</option>
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
                    <select id="state" v-model="filter.state" class="form-select form-select-sm" @change="fetchData"
                        aria-label="Filtrar por estado">
                        <option :value="''">Todos</option>
                        <option :value="'active'">Activos</option>
                        <option :value="'inactive'">Inactivos</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-primary border-primary text-white">
                        <small>Nombre</small>
                    </span>
                    <input type="text" class="form-control" v-model="filter.name" @input="fetchData"
                        aria-label="Filtrar por persona">
                </div>
            </div>
            <div class="col-md-1 d-grid gap-2">
                <button type="submit" class="btn btn-sm btn-success" aria-label="Buscar transacciones">
                    <i class="mdi mdi-search-web"></i>
                </button>
            </div>
            <div class="col-md-1 d-grid gap-2">
                <template v-if="getPermissions.includes('users.create')">
                    <router-link class="btn btn-sm btn-primary" :to="{ name: 'users.create' }" aria-label="Agregar usuario">
                        <i class="mdi mdi-plus"></i> Nuevo
                    </router-link>
                </template>
                <template v-else>
                    <button class="btn btn-danger" disabled>
                        <i class="mdi mdi-block-helper"></i> Nuevo
                    </button>
                </template>
            </div>
        </form>

        <!-- Tabla de resultados -->
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="card">
                    <div class="card-header bg-primary-lighten">
                        Usuarios
                    </div>
                    <div class="card-body" v-if="items.length > 0">
                        <div class="table-responsive-sm">
                            <table class="table table-bordered table-centered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th @click="toggleSort('firstname')">
                                            <span>Nombre</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('firstname')"></i>
                                        </th>
                                        <th @click="toggleSort('email')">
                                            <span>Email</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('email')"></i>
                                        </th>
                                        <th @click="toggleSort('created_at')">
                                            <span>Registrado:</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('created_at')"></i>
                                        </th>
                                        <th>Actualizar Estado</th>
                                        <th @click="toggleSort('state')">
                                            <span>Estado</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('state')"></i>
                                        </th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <transition-group name="fade" tag="tbody" mode="in-out">
                                    <tr v-for="(user, index) in items" :key="user.id">
                                        <td>{{ index + 1 }}</td>
                                        <td class="table-user">
                                            <img :src="user.file ? route + `/${user.file.path}` : route + '/default.png'"
                                                class="me-2 rounded-circle" alt="table-user">
                                            {{ user.firstname + ' ' + user.lastname }}
                                        </td>
                                        <td> {{ user.email }} </td>
                                        <td>{{ user.formatted_date }}</td>
                                        <td class="table-action text-center">
                                            <template v-if="getPermissions.includes('users.edit')">
                                                <label class="switch" aria-label="Cambiar estado">
                                                    <input type="checkbox" :checked="user.state === 'active'"
                                                        @change="toggleStatus(user)"
                                                        aria-checked="user.state === 'active'" />
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
                                            <span v-if="user.state === 'active'">
                                                <i class="mdi mdi-circle text-success"></i> Activo
                                            </span>
                                            <span v-else>
                                                <i class="mdi mdi-circle text-danger"></i> Inactivo
                                            </span>
                                        </td>
                                        <td class="table-action text-center">
                                            <template v-if="getPermissions.includes('users.edit')">
                                                <a href="#" class="btn action-icon" @click.prevent="editUser(user.id)">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                            </template>
                                            <template v-else>
                                                <button href="#" class="btn btn-sm" disabled>
                                                    <i class="mdi mdi-block-helper"></i>
                                                </button>
                                            </template>
                                        </td>
                                    </tr>
                                </transition-group>
                            </table>
                        </div>
                        <nav class="">
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

import dataMixin from "../mixins/dataMixin.js";
import toastMixin from "../mixins/toastMixin.js";

export default {
    props: ['route'],
    mixins: [dataMixin, toastMixin],

    data() {
        return {
            apiUrl: "/api/users/list",
            filter: {
                state: '',
                name: '',
            },
            getPermissions: JSON.parse(sessionStorage.getItem('permissions'))
        };
    },

    mounted() {
        this.fetchData();
    },

    methods: {

        fetchData(resetPagination = false) {
            this.loadData(this.apiUrl, resetPagination);
        },

        getFilterParams() {
            return {
                state: this.filter.state,
                name: this.filter.name,
            };
        },

        async toggleStatus(user) {
            const state = user.state === 'active' ? 'inactive' : 'active';
            try {
                await axios.put(`/api/users/${user.id}/state`, {
                    state: state,
                });
                user.state = state;
                this.showToast("Success, Actualizado!", {
                    type: "success"
                });
            } catch (error) {
                console.error('Error al actualizar el estado de la transacción:', error);
            }
        },

        changeItemsPerPage(newPerPage) {
            this.paginated.perPage = newPerPage;
            this.fetchData(true);
        },

        editUser(userId) {
            this.$router.push(`/users/edit/${userId}`);
        }

    },

};

</script>
