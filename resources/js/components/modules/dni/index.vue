<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">DNI</a></li>
                            <li class="breadcrumb-item active">Consulta de DNI</li>
                        </ol>
                    </div>
                    <h4 class="page-title">DNI</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills bg-nav-pills mb-3">
                            <li class="nav-item">
                                <a href="#bordered-tabs-query" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0 active" @click.prevent="cleanData">
                                    API Consultas de DNI
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#bordered-tabs-control" data-bs-toggle="tab" aria-expanded="true"
                                    class="nav-link rounded-0" @click.prevent="cleanData">
                                    Control Menores de Edad y Fallecidos
                                </a>
                            </li>
                        </ul> <!-- end nav-->
                        <div class="tab-content">
                            <div class="tab-pane show active" id="bordered-tabs-query">
                                <div class="mt-1">
                                    <p class="text-primary font-12 mb-4">
                                        <i class="uil-info-circle"></i>
                                        Servicio de consulta DNI (nombres y apellidos) en tiempo real desde el padrón
                                        reducido
                                        SUNAT y scraping de datos publicos
                                        <button class="btn btn-sm btn-info float-end" data-bs-toggle="modal"
                                            data-bs-target="#modal-info">
                                            <i class="uil-info-circle"></i>
                                            Consideraciones
                                        </button>
                                    </p>
                                </div>
                                <ul class="nav nav-tabs mb-3">
                                    <li class="nav-item">
                                        <a href="#individual1" data-bs-toggle="tab" aria-expanded="false"
                                            class="nav-link active" @click.prevent="cleanData">
                                            <i class="uil-user-square d-md-none d-block"></i>
                                            <span class="d-none d-md-block">Consulta Individual</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#massive1" data-bs-toggle="tab" aria-expanded="true" class="nav-link"
                                            @click.prevent="cleanData">
                                            <i class="uil-layer-group d-md-none d-block"></i>
                                            <span class="d-none d-md-block">Reporte Masivo</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="individual1">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="p-2 mt-2">
                                                    <form>
                                                        <div class="form-group mb-3">
                                                            <label for="dni-1">Número de DNI:
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" id="dni-1"
                                                                :class="['form-control', errors.dni ? 'is-invalid' : '']"
                                                                maxlength="8" v-model="dni">
                                                            <span v-if="errors.dni" class="invalid-feedback" role="alert">
                                                                {{ errors.dni }}
                                                            </span>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <button class="btn btn-primary mt-3" :disabled="isLoading"
                                                                @click="getDni(dni)">
                                                                <template v-if="isLoading">
                                                                    <span class="spinner-border spinner-border-sm me-1"
                                                                        role="status" aria-hidden="true">
                                                                    </span>
                                                                    Cargando...
                                                                </template>
                                                                <template v-else>
                                                                    <span class="mdi mdi-magnify"></span>
                                                                    Buscar
                                                                </template>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <transition name="fade">
                                                    <div class="p-2 mt-2" v-if="isLoading">
                                                        <div class="d-flex align-items-center">
                                                            <strong>Cargando...</strong>
                                                            <div class="spinner-border ms-auto" role="status"
                                                                aria-hidden="true"></div>
                                                        </div>
                                                    </div>
                                                    <div class="p-2 mt-2" v-else>
                                                        <div class="alert alert-primary alert-dismissible border-0 fade show"
                                                            role="alert" v-if="cardResult">
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                                aria-label="Close" disabled></button>
                                                            <h4>
                                                                <i class="dripicons-checkmark me-2"></i>
                                                                ¡Success!
                                                            </h4>
                                                            <div>
                                                                <vue-json-pretty :data="data" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </transition>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="massive1">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="p-2 mt-2">
                                                    <div class="mb-4 text-center bg-primary rounded-3 p-2">
                                                        <span class="font-14 text-white ">
                                                            DNIs | Consulta máxima 200 registros
                                                        </span>
                                                    </div>
                                                    <form>
                                                        <div class="form-group mb-3">
                                                            <label for="massive-1">Lista de DNIs:
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <textarea class="form-control" id="massive-1" cols="30"
                                                                rows="10" v-model="dnis"></textarea>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <button class="btn btn-primary mt-3" :disabled="isLoading"
                                                                @click.prevent="getDniMultiple()">
                                                                <template v-if="isLoading">
                                                                    <span class="spinner-border spinner-border-sm me-1"
                                                                        role="status" aria-hidden="true">
                                                                    </span>
                                                                    Cargando...
                                                                </template>
                                                                <template v-else>
                                                                    <span class="mdi mdi-magnify"></span>
                                                                    Buscar
                                                                </template>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <transition name="fade">
                                                    <div v-if="isFetching" class="p-2 mt-2">
                                                        <div class="progress mb-3">
                                                            <div class="progress-bar progress-bar-striped bg-success"
                                                                role="progressbar" :style="{ width: fetchProgress + '%' }"
                                                                :aria-valuenow="fetchProgress" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                                {{ fetchProgress }}%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </transition>

                                                <transition name="fade">
                                                    <div class="p-2 mt-2" v-if="isLoading">
                                                        <div class="d-flex align-items-center">
                                                            <strong>Cargando...</strong>
                                                            <div class="spinner-border ms-auto" role="status"
                                                                aria-hidden="true"></div>
                                                        </div>
                                                    </div>
                                                </transition>

                                                <transition name="fade">
                                                    <div class="p-2 mt-2" v-if="cardResultMassive && !isFetching">
                                                        <div class="alert alert-info" role="alert">
                                                            <h3 class="mb-3">
                                                                <strong>
                                                                    <i class="dripicons-checkmark me-2"></i>
                                                                    ¡Success!
                                                                </strong>
                                                            </h3>
                                                            <p class="font-16">Total de consultas: {{ totalDnis }}</p>
                                                            <p class="font-16">Consultas completadas: {{ completedDnis }}
                                                            </p>
                                                            <p class="font-16 text-danger">Error en consultas:
                                                                {{ errorDnis }}
                                                            </p>
                                                            <button class="btn btn-sm btn-success mb-2"
                                                                @click="exportToExcel">
                                                                <span class="mdi mdi-download"></span>
                                                                Exportar en excel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </transition>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="bordered-tabs-control">
                                <div class="mt-1">
                                    <p class="text-primary font-12 mb-4">
                                        <i class="uil-info-circle"></i>
                                        Validación confiable y segura de DNI para verificar menores de edad y el estado
                                        vital de personas mediante RENIEC.
                                        <button class="btn btn-sm btn-info float-end" data-bs-toggle="modal"
                                            data-bs-target="#modal-info2">
                                            <i class="uil-info-circle"></i>
                                            Consideraciones
                                        </button>
                                    </p>
                                </div>
                                <ul class="nav nav-tabs mb-3">
                                    <li class="nav-item">
                                        <a href="#individual2" data-bs-toggle="tab" aria-expanded="false"
                                            class="nav-link active" @click.prevent="cleanData">
                                            <i class="uil-user-square d-md-none d-block"></i>
                                            <span class="d-none d-md-block">DNI individual</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#massive2" data-bs-toggle="tab" aria-expanded="true" class="nav-link"
                                            @click.prevent="cleanData">
                                            <i class="uil-layer-group d-md-none d-block"></i>
                                            <span class="d-none d-md-block">Control Masivo</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="individual2">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="p-2 mt-2">
                                                    <form>
                                                        <input type="hidden" v-model="cookies">
                                                        <div class="form-group mb-4">
                                                            <div class="text-center shadow-sm p-2 rounded-3"
                                                                v-if="!isLoading">
                                                                <img :src="captchaImage" alt="..." class="scale-up-center">
                                                            </div>
                                                            <div class="text-center  shadow-sm p-2" v-else>
                                                                <div class="spinner-border spinner-border-sm text-success"
                                                                    role="status"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="dni-1">Captcha:
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" id="dni-1"
                                                                :class="['form-control', errors.captcha ? 'is-invalid' : '']"
                                                                v-model="captcha">
                                                            <span v-if="errors.captcha" class="invalid-feedback"
                                                                role="alert">
                                                                {{ errors.captcha }}
                                                            </span>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="dni-1">Número de DNI:
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" id="dni-1"
                                                                :class="['form-control', errors.dniMinorsDeceased ? 'is-invalid' : '']"
                                                                maxlength="8" v-model="dniMinorsDeceased">
                                                            <span v-if="errors.dniMinorsDeceased" class="invalid-feedback"
                                                                role="alert">
                                                                {{ errors.dniMinorsDeceased }}
                                                            </span>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <button class="btn btn-primary mt-3" :disabled="isLoading"
                                                                @click="getMinorsDeceased(dniMinorsDeceased, cookies, captcha)">
                                                                <template v-if="isLoading">
                                                                    <span class="spinner-border spinner-border-sm me-1"
                                                                        role="status" aria-hidden="true">
                                                                    </span>
                                                                    Cargando...
                                                                </template>
                                                                <template v-else>
                                                                    <span class="mdi mdi-magnify"></span>
                                                                    Buscar
                                                                </template>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <transition name="fade">
                                                    <div class="p-2 mt-2" v-if="isLoading">
                                                        <div class="d-flex align-items-center">
                                                            <strong>Cargando...</strong>
                                                            <div class="spinner-border ms-auto" role="status"
                                                                aria-hidden="true"></div>
                                                        </div>
                                                    </div>
                                                    <div class="p-2 mt-2" v-else>
                                                        <div :class="getAlertClass(data.messageCode)" role="alert"
                                                            v-if="cardResult">
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                                aria-label="Close" disabled></button>
                                                            <h4>
                                                                <i class="dripicons-checkmark me-2"></i>
                                                                ¡Success!
                                                            </h4>
                                                            <div class="mt-4 font-20">
                                                                <p v-if="data.messageCode === 9006">El DNI consultado está
                                                                    cancelado, motivo: A - fallecimiento</p>
                                                                <p v-else-if="data.messageCode === 9002">El DNI consultado
                                                                    corresponde a un menor de edad</p>
                                                                <p v-else-if="data.messageCode === 9004">Error en la
                                                                    cantidad de dígitos</p>
                                                                <p v-else-if="data.messageCode === 8000">Sin observaciones
                                                                </p>
                                                                <p v-else>Revisar la información de su DNI</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </transition>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="massive2">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="p-2 mt-2">
                                                    <div class="mb-4 text-center rounded-3 bg-secondary shadow-sm p-2">
                                                        <span class="font-14 text-white">
                                                            DNIs | Consulta máxima 200 registros
                                                        </span>
                                                    </div>
                                                    <form>
                                                        <input type="hidden" v-model="cookies">
                                                        <div class="form-group mb-4">
                                                            <div class="text-center shadow-sm p-2 rounded-3"
                                                                v-if="!isLoading">
                                                                <img :src="captchaImage" alt="..." class="scale-up-center">
                                                            </div>
                                                            <div class="text-center  shadow-sm p-2" v-else>
                                                                <div class="spinner-border spinner-border-sm text-success"
                                                                    role="status"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="dni-1">Captcha:
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" id="dni-1"
                                                                :class="['form-control', errors.captcha ? 'is-invalid' : '']"
                                                                v-model="captcha">
                                                            <span v-if="errors.captcha" class="invalid-feedback"
                                                                role="alert">
                                                                {{ errors.captcha }}
                                                            </span>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="massive-1">Lista de DNIs:
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <textarea class="form-control" id="massive-1" cols="30"
                                                                rows="10" v-model="dnis"></textarea>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <button class="btn btn-primary mt-3" :disabled="isLoading"
                                                                @click="getMultipleMinorsDeceased(dnis, cookies, captcha)">
                                                                <template v-if="isLoading">
                                                                    <span class="spinner-border spinner-border-sm me-1"
                                                                        role="status" aria-hidden="true">
                                                                    </span>
                                                                    Cargando...
                                                                </template>
                                                                <template v-else>
                                                                    <span class="mdi mdi-magnify"></span>
                                                                    Buscar
                                                                </template>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <transition name="fade">
                                                    <div v-if="isFetching" class="p-2 mt-2">
                                                        <div class="progress mb-3">
                                                            <div class="progress-bar progress-bar-striped bg-success"
                                                                role="progressbar" :style="{ width: fetchProgress + '%' }"
                                                                :aria-valuenow="fetchProgress" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                                {{ fetchProgress }}%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </transition>

                                                <transition name="fade">
                                                    <div class="p-2 mt-2" v-if="isLoading">
                                                        <div class="d-flex align-items-center">
                                                            <strong>Cargando...</strong>
                                                            <div class="spinner-border ms-auto" role="status"
                                                                aria-hidden="true"></div>
                                                        </div>
                                                    </div>
                                                </transition>
                                                <transition name="fade">
                                                    <div class="p-2 mt-2" v-if="cardResultMassive && !isFetching">
                                                        <div class="alert alert-info" role="alert">
                                                            <h3 class="mb-3">
                                                                <strong>
                                                                    <i class="dripicons-checkmark me-2"></i>
                                                                    ¡Success!
                                                                </strong>
                                                            </h3>
                                                            <p class="font-16">Total de consultas: {{ totalDnis }}</p>
                                                            <p class="font-16">Consultas completadas: {{ completedDnis }}
                                                            </p>
                                                            <p class="font-16 text-danger">Error en consultas:
                                                                {{ errorDnis }}
                                                            </p>
                                                            <button class="btn btn-sm btn-success mb-2"
                                                                @click="exportToExcel">
                                                                <span class="mdi mdi-download"></span>
                                                                Exportar en excel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </transition>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end tab-content-->
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card-->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

        <!-- Info modal -->
        <div id="modal-info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-infoLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-primary">
                        <h4 class="modal-title" id="primary-header-modalLabel">Información</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action">
                                Este servicio no se conecta con RENIEC
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                El origen de datos depende del padrón reducido SUNAT y otras fuentes públicas.
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                El padrón reducido SUNAT no devuelve datos de menores de edad, dirección, fecha nacimiento,
                                sexo.
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                En algunos casos no se obtendrá resultado de la consulta debido a la información de las
                                fuentes
                                públicas, esto no debe considerarse como falla o error del servicio.
                            </a>

                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!-- Info modal -->
        <div id="modal-info2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-info2Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-primary">
                        <h4 class="modal-title" id="primary-header-modalLabel">Información</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action">
                                Nuestro sistema utiliza datos provenientes de la Reniec (Registro Nacional de Identificación
                                y Estado Civil).
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                Estas consultas no proporciona datos como nombres, apellidos, sexo o fecha de nacimiento.
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                Para garantizar la autenticidad de las consultas, RENIEC incorpora un sistema de validación
                                captcha en nuestro proceso de obtención de datos.
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                Cada consulta se realiza con un intervalo de 2/3 segundos para evitar bloqueos, esto
                                garantiza disponibilidad equitativa y fomenta un uso responsable de la plataforma.
                            </a>

                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</template>

<script>

import toastMixin from "../mixins/toastMixin.js";
import VueJsonPretty from 'vue-json-pretty';
import 'vue-json-pretty/lib/styles.css';
import * as XLSX from 'xlsx'

export default {

    props: ['route'],
    mixins: [toastMixin],
    components: { VueJsonPretty },

    data() {
        return {
            totalDnis: '',
            errorDnis: '',
            completedDnis: '',
            dniMinorsDeceased: '',
            captchaImage: '',
            cardResult: false,
            cardResultMassive: false,
            isFetching: false,
            isLoading: false,
            fetchProgress: 0,
            responses: [],
            data: {},
            cookies: '',
            captcha: '',
            dni: '',
            dnis: '',
            errors: {
                dni: '',
                captcha: '',
                dniMinorsDeceased: ''
            },

        }
    },

    mounted() {
        this.getCookiesCaptcha();
        this.updateCaptcha();
    },

    computed: {
        totalPages() {
            return Math.ceil(this.responses.length / this.pageSize)
        },
        paginatedResponses() {
            const startIndex = (this.currentPage - 1) * this.pageSize
            const endIndex = startIndex + this.pageSize
            return this.responses.slice(startIndex, endIndex)
        },
        visiblePages() {
            const surroundingPages = 2;
            let pages = [];

            pages.push(1);
            pages.push(this.totalPages);

            for (let i = this.currentPage - surroundingPages; i <= this.currentPage + surroundingPages; i++) {
                if (i > 1 && i < this.totalPages) {
                    pages.push(i);
                }
            }

            pages = [...new Set(pages)].sort((a, b) => a - b);

            const pagesWithEllipsis = [];
            let previousPage = 0;
            for (const page of pages) {
                if (page - previousPage > 1) {
                    pagesWithEllipsis.push(null);
                }
                pagesWithEllipsis.push(page);
                previousPage = page;
            }

            return pagesWithEllipsis;
        }
    },

    methods: {
        async getDni(dni) {

            this.isLoading = true;
            this.cardResult = false;
            this.errors = {};
            this.data = {};

            try {
                const response = await axios.get('/admin/dni/query', { params: { dni } });


                const errorDni = response.data.data.error;

                if (errorDni === 404) {
                    this.showToast('Error al obtener los datos', { type: "error" });
                    return
                }

                this.showToast("Success", { type: "success" });
                this.data = response.data;
                this.cardResult = true;
                this.dni = '';

                return response;

            } catch (error) {

                const errors = error.response.data.errors;
                this.errors.dni = errors.dni ? errors.dni[0] : false;

                this.showToast(error.response.data.message, { type: "error" });

            } finally {
                this.isLoading = false;
            }
        },
        async getMinorsDeceased(dniMinorsDeceased, cookie, captcha) {

            this.isLoading = true;
            this.cardResult = false;
            this.errors = {};
            this.data = {};

            try {
                const response = await axios.post('/admin/dni/minors-deceased', { dniMinorsDeceased, cookie, captcha });

                const status = response.data.data.status;
                const message = response.data.data.message;

                if (status === 406) {
                    this.showToast(message, { type: "error" });
                    this.getCookiesCaptcha();
                    return
                }

                this.showToast("Success", { type: "success" });
                this.data = response.data.data;
                this.getCookiesCaptcha();
                this.cardResult = true;
                this.dniMinorsDeceased = '';
                this.captcha = '';

                return response;

            } catch (error) {

                const errors = error.response.data.errors;
                this.errors.dniMinorsDeceased = errors.dniMinorsDeceased ? errors.dniMinorsDeceased[0] : false;
                this.errors.captcha = errors.captcha ? errors.captcha[0] : false;
                this.errors.cookie = errors.cookie ? errors.cookie[0] : false;

                this.showToast(error.response.data.message, { type: "error" });

            } finally {
                setTimeout(() => {
                    this.isLoading = false;
                }, 1000);

            }
        },
        async getCookiesCaptcha() {
            const response = await axios.get('/admin/dni/cookies-captcha');
            this.cookies = response.data;
            this.updateCaptcha();
            return response.data;
        },
        async getDniMultiple() {

            if (!this.dnis || this.dnis.trim() === '') {
                this.showToast("Por favor, introduce los DNIs", {
                    type: "warning"
                })
                return
            };
            const dniArray = this.dnis.split('\n')
            if (dniArray.length > 200) {
                this.showToast("Por favor, introduce hasta 200 DNIs", {
                    type: "warning"
                })
                return
            };

            this.responses = [];
            this.isFetching = true;
            this.isLoading = true;
            this.cardResultMassive = false;
            this.fetchProgress = 0;

            const totalDnis = dniArray.length;
            let completedDnis = 0;
            let errorDnis = 0;

            for (const dni of dniArray) {
                const trimmedDni = dni.trim()
                if (trimmedDni.length > 0) {
                    try {
                        const response = await axios.get('/admin/dni/query', { params: { dni: trimmedDni } });

                        if (response.status === 200) {
                            this.responses.push(response.data.data)
                        } else {
                            this.showToast("Error al buscar el DNI", { type: "error" });
                        }

                        if (response.data.data.error === 404) {
                            errorDnis++
                        }
                    } catch (error) {
                        this.showToast("Error al buscar el DNI", { type: "error" });
                    }
                } else {
                    console.error('Ingrese una DNI válido')
                }

                completedDnis++;
                this.fetchProgress = Math.round((completedDnis / totalDnis) * 100);

                this.totalDnis = totalDnis;
                this.completedDnis = completedDnis;
                this.errorDnis = errorDnis;
            }

            if (!this.responses.length) {
                this.showToast("No se encontró información, revise sus datos", { type: "error" });
                this.isFetching = false;
                this.isLoading = false;
                this.dnis = '';
            } else {
                setTimeout(() => {
                    this.isFetching = false;
                    this.cardResultMassive = true;
                    this.isLoading = false;
                    this.dnis = '';
                    this.showToast("Se cargaron los datos", { type: "success" });
                }, 2000);
            }

        },
        async getMultipleMinorsDeceased(dnis, cookie, captcha) {

            if (!this.dnis || this.dnis.trim() === '') {
                this.showToast("Por favor, introduce los DNIs", {
                    type: "warning"
                })
                return
            };

            const dniArray = this.dnis.split('\n')
            if (dniArray.length > 200) {
                this.showToast("Por favor, introduce hasta 200 DNIs", {
                    type: "warning"
                })
                return
            };

            this.responses = [];
            this.isFetching = true;
            this.isLoading = true;
            this.cardResultMassive = false;
            this.fetchProgress = 0;

            const totalDnis = dniArray.length;
            let completedDnis = 0;
            let errorDnis = 0;

            for (const dni of dniArray) {
                const trimmedDni = dni.trim()
                if (trimmedDni.length > 0) {
                    try {
                        const response = await axios.post('/admin/dni/minors-deceased', {
                            dniMinorsDeceased: trimmedDni,
                            cookie: cookie,
                            captcha: captcha
                        });

                        console.log(response.data)

                        if (response.status === 200) {

                            const messageCode = response.data.data.messageCode;

                            const result = {
                                dni: trimmedDni,
                                comment: "",
                                messageCode: response.data.data.messageCode,
                            };

                            if (messageCode === 9006) {
                                result.comment = "El DNI consultado está cancelado, motivo: A - fallecimiento";
                            } else if (messageCode === 9002) {
                                result.comment = "El DNI consultado corresponde a un menor de edad";
                            } else if (messageCode === 9004) {
                                result.comment = "Error en la cantidad de dígitos";
                            } else if (messageCode === 8000) {
                                result.comment = "Sin observaciones";
                            } else if (messageCode === 9001) {
                                result.comment = "El DNI consultado no existe";
                            } else {
                                result.messageCode = '0000';
                                result.comment = "No se encontraron resultados";
                            };

                            this.responses.push(result);

                        } else {
                            this.showToast("Error al buscar el DNI", { type: "error" });
                        }

                    } catch (error) {
                        this.showToast("Error al buscar el DNI", { type: "error" });

                    }
                } else {
                    console.error('Ingrese una DNI válido')
                }

                completedDnis++;
                this.fetchProgress = Math.round((completedDnis / totalDnis) * 100);
                this.totalDnis = totalDnis;
                this.completedDnis = completedDnis;
                this.errorDnis = errorDnis;
            }

            if (!this.responses.length) {
                this.showToast("No se encontró información, revise sus datos", { type: "error" });
                this.isFetching = false;
                this.isLoading = false;
                this.getCookiesCaptcha();
                this.dnis = '';
            } else {
                setTimeout(() => {
                    this.isFetching = false;
                    this.cardResultMassive = true;
                    this.isLoading = false;
                    this.getCookiesCaptcha();
                    this.dnis = '';
                    this.captcha = '';
                    this.showToast("Se cargaron los datos", { type: "success" });
                }, 2000);
            }
        },
        updateCaptcha() {
            this.captchaImage = `${this.route}/captcha.jpg?timestamp=${Date.now()}`;
        },
        cleanData() {
            this.dniMinorsDeceased = '',
                this.cardResult = false,
                this.cardResultMassive = false
            this.isFetching = false,
                this.isLoading = false,
                this.fetchProgress = 0,
                this.data = {},
                this.responses = [],
                this.captcha = '',
                this.totalDnis = '',
                this.errorDnis = '',
                this.completedDnis = '',
                this.dni = '',
                this.dnis = '',
                this.errors = {
                    dni: '',
                    captcha: '',
                    dniMinorsDeceased: ''
                };
        },
        getAlertClass(messageCode) {
            if (messageCode === 9006) {
                return 'alert alert-secondary alert-dismissible bg-secondary text-white border-0 fade show';
            } else if (messageCode === 9002) {
                return 'alert alert-warning alert-dismissible bg-warning text-white border-0 fade show';
            } else if (messageCode === 9004) {
                return 'alert alert-danger alert-dismissible bg-danger text-white border-0 fade show';
            } else if (messageCode === 8000) {
                return 'alert alert-success alert-dismissible bg-success text-white border-0 fade show';
            } else {
                return 'alert alert-primary alert-dismissible bg-primary text-white border-0 fade show';
            }
        },
        exportToExcel() {
            const worksheet = XLSX.utils.json_to_sheet(this.responses)
            const workbook = XLSX.utils.book_new()
            XLSX.utils.book_append_sheet(workbook, worksheet, 'ips')
            const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' })
            const fileName = `dnis_${this.getCurrentTime()}.xlsx`
            this.saveExcelFile(excelBuffer, fileName)
        },
        saveExcelFile(buffer, fileName) {
            const data = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
            const link = document.createElement('a')
            link.href = URL.createObjectURL(data)
            link.download = fileName
            link.click()
        },
        getCurrentTime() {
            const now = new Date()
            const hours = now.getHours().toString().padStart(2, '0')
            const minutes = now.getMinutes().toString().padStart(2, '0')
            const seconds = now.getSeconds().toString().padStart(2, '0')
            return `${hours}${minutes}${seconds}`
        }
    },
};

</script>
