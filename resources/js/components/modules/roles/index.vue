<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Roles</a></li>
                            <li class="breadcrumb-item active">Listado de Roles</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Roles</h4>
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
                    <select id="perPage" v-model="paginated.perPage" class="form-select form-select-sm"  @change="changeItemsPerPage(paginated.perPage)" aria-label="Mostrar resultados por página">
                        <option :value="5">5</option>
                        <option :value="10">10</option>
                        <option :value="20">20</option>
                        <option :value="50">50</option>
                        <option :value="100">100</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-primary border-primary text-white">
                        <small>Slug</small>
                    </span>
                    <input type="text" class="form-control" v-model="filter.slug" @input="fetchData" aria-label="Filtrar por persona">
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-primary border-primary text-white">
                        <small>Nombre</small>
                    </span>
                    <input type="text" class="form-control" v-model="filter.name" @input="fetchData" aria-label="Filtrar por persona">
                </div>
            </div>
            <div class="col-md-1 d-grid gap-2">
                <button type="submit" class="btn btn-sm btn-success" aria-label="Buscar transacciones">
                    <i class="mdi mdi-search-web"></i>
                </button>
            </div>
            <div class="col-md-1 d-grid gap-2">
                <template v-if="getPermissions.includes('roles.create')">
                    <router-link class="btn btn-sm btn-primary" :to="{ name: 'roles.create' }" aria-label="Agregar usuario">
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
                        Roles
                    </div>
                    <div class="card-body" v-if="items.length > 0">
                        <div class="table-responsive">
                            <table class="table table-centered table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th @click="toggleSort('name')">
                                            <span>Nombre</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('name')"></i>
                                        </th>
                                        <th @click="toggleSort('slug')">
                                            <span>Slug</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('slug')"></i>
                                        </th>
                                        <th @click="toggleSort('created_at')">
                                            <span>Registrado:</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('created_at')"></i>
                                        </th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <transition-group name="fade" tag="tbody" mode="in-out">
                                    <tr v-for="(role, index) in items" :key="role.id">
                                        <td>{{ index + 1 }}</td>
                                        <td> {{ role.name }} </td>
                                        <td>{{ role.slug }}</td>
                                        <td>{{ role.formatted_date }}</td>
                                        <td class="table-action text-center">
                                            <template v-if="getPermissions.includes('roles.edit')">
                                                <a href="#" class="btn action-icon" @click.prevent="editRole(role.id)">
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
                        <nav class="mt-1">
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
        <!-- end row -->
    </div>
</template>

<script>

import dataMixin from "../mixins/dataMixin.js";
import toastMixin from "../mixins/toastMixin.js";

export default {

    mixins: [dataMixin, toastMixin],

    data() {
        return {
            apiUrl: "/api/roles/list",
            filter: {
                name : '',
                slug : ''
            },
            paginated: {
                perPage: 10,
            },
            getPermissions: JSON.parse(localStorage.getItem('permissions'))
        };
    },

    mounted() {
        this.fetchData();
    },

    methods: {

        fetchData(resetPagination = false) {
            this.loadData(this.apiUrl, resetPagination );
        },

        getFilterParams() {
            return {
                name: this.filter.name,
                slug: this.filter.slug,
            };
        },

        changeItemsPerPage(newPerPage) {
            this.paginated.perPage = newPerPage;
            this.fetchData(true);
        },

        editRole(roleId) {
            this.$router.push(`/roles/edit/${roleId}`);
        },

    },

};

</script>
