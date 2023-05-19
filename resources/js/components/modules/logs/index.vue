<!-- 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 -->
<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Logs</a></li>
                            <li class="breadcrumb-item active">Listado de Logs</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Logs</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Tabla de Resultados -->
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body" v-if="items.length > 0">
                        <div class="table-responsive-sm">
                            <table class="table table-bordered table-centered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th @click="toggleSort('type')">
                                            <span>Type</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('type')"></i>
                                        </th>
                                        <th @click="toggleSort('email')">
                                            <span>Email</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('email')"></i>
                                        </th>
                                        <th @click="toggleSort('ip')">
                                            <span>IP</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('ip')"></i>
                                        </th>
                                        <th @click="toggleSort('created_at')">
                                            <span>Registrado:</span>
                                            &nbsp;
                                            <i class="mdi" :class="getSortIconClass('created_at')"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <transition-group name="fade" tag="tbody" mode="in-out">
                                    <tr v-for="(logs, index) in items" :key="logs.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <div class="logs-type shadow">
                                                {{ logs.type }}
                                            </div>
                                        </td>
                                        <td> {{ logs.email }} </td>
                                        <td> {{ logs.ip }} </td>
                                        <td>{{ logs.formatted_date }}</td>
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
            <div class="col-md-3">
                <div class="row">
                    <div class="col-12 mb-3">
                        <!-- Formulario de filtro -->
                        <form class="row g-1" @submit.prevent="fetchData">
                            <div class="col-12">
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
                            <div class="col-12">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-primary border-primary text-white">
                                        <small>Email</small>
                                    </span>
                                    <input type="text" class="form-control" v-model="filter.email" @input="fetchData"
                                        aria-label="Filtrar por email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-primary border-primary text-white">
                                        <small>Desde</small>
                                    </span>
                                    <input type="datetime-local" class="form-control" id="startDate"
                                        v-model="filter.startDate" aria-label="Filtrar por fecha de inicio">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-primary border-primary text-white">
                                        <small>Hasta</small>
                                    </span>
                                    <input type="datetime-local" class="form-control" id="endDate" v-model="filter.endDate"
                                        aria-label="Filtrar por fecha de fin">
                                </div>
                            </div>
                            <div class="col-12 d-grid gap-2">
                                <button type="submit" class="btn btn-sm btn-success" aria-label="Buscar transacciones">
                                    <i class="mdi mdi-search-web"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title">
                                    Lenguajes de Programación
                                </h6>
                            </div>
                            <div v-if="!loadingLanguages">
                                <div class="card-body" v-if="Object.keys(languages).length > 0">
                                    <div class="progress">
                                        <div v-for="(percentage, language) in languagePercentages" :key="language"
                                            :class="getProgressBarClasses(language)" :style="{ width: percentage + '%' }"
                                            role="progressbar" :aria-valuenow="percentage" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <ul class="nav justify-content-start">
                                        <li class="nav-item" v-for="(percentage, language) in languagePercentages"
                                            :key="language">
                                            <a href="#" class="nav-link">
                                                <span :class="getIconClasses(language)"></span>
                                                {{ language }}: {{ percentage }}%
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                            <div class="card-body" v-else>
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    Últimas 3 actualizaciones:
                                </div>
                            </div>
                            <div v-if="!loadingLanguages">
                                <div class="m-3" v-for="commit in lastCommits" :key="commit.sha">
                                    <img :src="commit.author.avatar_url" alt="image" class="img-fluid avatar-xs">
                                    <p class="pt-1 text-success">{{ commit.author.login }}</p>
                                    <span class="d-block"><strong>Nombre:</strong> {{ commit.commit.author.name }}</span>
                                    <span class="d-block"><strong>Email:</strong> {{ commit.commit.author.email }}</span>
                                    <span class="d-block"><strong>Fecha:</strong>
                                        {{ formatDate(commit.commit.author.date) }}
                                    </span>
                                    <span class="d-block"><strong>Cambios:</strong> {{ commit.commit.message }}</span>
                                    <hr>
                                </div>
                            </div>
                            <div class="card-body" v-else>
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border text-success" role="status">
                                        <span class="visually-hidden">Loading...</span>
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
import { format, subDays } from 'date-fns';
import axios from 'axios';

export default {

    mixins: [dataMixin, toastMixin],

    data() {
        return {
            languages: {},
            lastcommits: {},
            loadingLanguages: true,
            apiUrl: "/api/logs/list",
            filter: {
                email: '',
            },
        };
    },

    mounted() {
        this.fetchData();
        this.setDefaultDates();
        this.fetchGithub();

        this.updateInterval = setInterval(() => {
            this.fetchData();
        }, 5000);

    },

    computed: {
        languagePercentages() {
            const totalBytes = Object.values(this.languages).reduce((sum, value) => sum + value, 0);

            return Object.entries(this.languages).reduce((percentages, [language, bytes]) => {
                const percentage = ((bytes / totalBytes) * 100).toFixed(2);
                return { ...percentages, [language]: percentage };
            }, {});
        },
    },

    methods: {
        fetchData(resetPagination = false) {
            this.loadData(this.apiUrl, resetPagination);
        },

        getFilterParams() {
            return {
                email: this.filter.email,
                startDate: this.filter.startDate,
                endDate: this.filter.endDate,
                page: this.paginated.page,
                perPage: this.paginated.perPage,
            };
        },

        async fetchGithub() {
            try {
                const response = await axios.get('/api/logs/github');
                this.languages = response.data.languages;
                this.loadingLanguages = false;

                const commits = response.data.changes.commits;

                if (commits.length > 0) {
                    this.lastCommits = commits.slice(0, 3);
                }

                console.log(commits)

            } catch (error) {
                console.error(error);
            }
        },

        getProgressBarClasses(language) {
            switch (language.toLowerCase()) {
                case 'vue':
                    return 'progress-bar bg-success';
                case 'php':
                    return 'progress-bar';
                case 'blade':
                    return 'progress-bar bg-danger';
                case 'javascript':
                    return 'progress-bar bg-warning';
                case 'css':
                    return 'progress-bar bg-info';
                case 'scss':
                    return 'progress-bar bg-pink';
                default:
                    return 'progress-bar bg-primary';
            }
        },

        getIconClasses(language) {
            switch (language.toLowerCase()) {
                case 'vue':
                    return 'mdi mdi-checkbox-blank-circle text-success';
                case 'php':
                    return 'mdi mdi-checkbox-blank-circle';
                case 'blade':
                    return 'mdi mdi-checkbox-blank-circle text-danger';
                case 'javascript':
                    return 'mdi mdi-checkbox-blank-circle text-warning';
                case 'css':
                    return 'mdi mdi-checkbox-blank-circle text-info';
                case 'scss':
                    return 'mdi mdi-checkbox-blank-circle text-pink';
                default:
                    return 'mdi mdi-checkbox-blank-circle text-primary';
            }
        },

        changeItemsPerPage(newPerPage) {
            this.paginated.perPage = newPerPage;
            this.fetchData(true);
        },

        setDefaultDates() {

            const endDate = new Date();
            const startDate = subDays(endDate, 1);


            endDate.setDate(endDate.getDate() + 1);
            endDate.setHours(0, 0, 0, 0);

            this.filter.startDate = format(startDate, 'yyyy-MM-dd hh:mm');
            this.filter.endDate = format(endDate, 'yyyy-MM-dd HH:mm');
        },

        formatDate(date) {
            return format(new Date(date), 'dd/MM/yyyy HH:mm:ss');
        },
    }
};
</script>

<style>
.logs-type {
    border-left: solid 3px #8d8d8d !important;
    padding: 20px 10px;
}
</style>
