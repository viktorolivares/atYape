<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Dominios</a></li>
                            <li class="breadcrumb-item active">Consulta de Dominios</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Dominios</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title font-14 text-primary">
                            Dominios | Máximo 10 Consultas
                        </span>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Consultas máximas por mes: 5000</p>
                        <textarea class="form-control" v-model="domains" rows="10"></textarea>
                        <button class="btn btn-primary mt-3" :disabled="isFetching" @click.prevent="fetchDomains">
                            <template v-if="isFetching">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            </template>
                            <template v-else>
                                <span class="mdi mdi-magnify"></span>
                                Buscar Dominios
                            </template>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div v-if="isFetching" class="card">
                    <div class="card-body">
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                :style="{ width: fetchProgress + '%' }" :aria-valuenow="fetchProgress" aria-valuemin="0"
                                aria-valuemax="100">
                                {{ fetchProgress }}%
                            </div>
                        </div>
                    </div>
                </div>

                <transition name="fade">
                    <div class="card" v-if="showTable && !isFetching">
                        <div class="px-3 pt-2">
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <span class="mdi mdi-information"></span>
                                <strong>API: ipqualityscore.com:</strong>
                                <span>Prueba de reputación de dominio, incluyen phishing, malware, SPAM, Temp-Email</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                    disabled></button>
                            </div>
                        </div>

                        <div class="card-body">
                            <button class="btn btn-sm btn-success float-end mb-2" @click="exportToExcel">
                                <span class="mdi mdi-download"></span>
                                Exportar en excel
                            </button>

                            <table class="table table-sm table-bordered table-condensed table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Dominio</th>
                                        <th scope="col">Categoría</th>
                                        <th scope="col">Flag</th>
                                        <th scope="col">Score</th>
                                        <th scope="col">Score ID</th>
                                        <th scope="col">Domain Age</th>
                                    </tr>
                                </thead>
                                <transition-group name="fade">
                                    <tbody>
                                        <tr v-for="(data, index) in paginatedResponses" :key="index">
                                            <th scope="row">{{ index + 1 }}</th>
                                            <td>{{ data.domain }}</td>
                                            <td>{{ data.category }}</td>
                                            <td>
                                                <template
                                                    v-if="!data.malware && !data.parking && !data.phishing && !data.spamming && !data.suspicious && !data.unsafe">
                                                    <span class="badge bg-success mx-1">Dominio seguro</span>
                                                </template>
                                                <template v-else>
                                                    <span v-if="data.malware" class="badge bg-danger mx-1">Malware</span>
                                                    <span v-if="data.parking" class="badge bg-danger mx-1">Email
                                                        temporal</span>
                                                    <span v-if="data.phishing" class="badge bg-danger mx-1">Suplantación de
                                                        identidad</span>
                                                    <span v-if="data.spamming" class="badge bg-danger mx-1">Spam</span>
                                                    <span v-if="data.suspicious"
                                                        class="badge bg-warning mx-1">Sospechoso</span>
                                                    <span v-if="data.unsafe" class="badge bg-warning mx-1">Inseguro</span>
                                                </template>
                                            </td>
                                            <td>
                                                <span v-html="getScoreBadge(data.risk_score)"></span>
                                            </td>
                                            <td>{{ data.risk_score ? data.risk_score : '-' }}</td>
                                            <td>{{ data.domain_age.human }}</td>
                                        </tr>
                                    </tbody>
                                </transition-group>
                            </table>

                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                                        <a class="page-link" href="#" @click.prevent="goToPage(currentPage - 1)">
                                            Anterior
                                        </a>
                                    </li>
                                    <li class="page-item" v-for="page in totalPages" :key="page"
                                        :class="{ 'active': currentPage === page }">
                                        <a class="page-link" href="#" @click.prevent="goToPage(page)">
                                            {{ page }}
                                        </a>
                                    </li>
                                    <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                                        <a class="page-link" href="#" @click.prevent="goToPage(currentPage + 1)">
                                            Siguiente
                                        </a>
                                    </li>
                                </ul>
                            </nav>

                            <h6 class="text-info">Créditos disponibles: {{ credits.credits }}</h6>
                        </div>
                    </div>
                </transition>

                <transition name="fade">
                    <div class="card" v-if="loading">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <strong>Cargando...</strong>
                                <div class="spinner-border text-primary ms-auto" role="status" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>
                </transition>

                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Scores:</h6>
                    </div>
                    <div class="card-body">
                        <ol class="list-group list-group-numbered shadow">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    Puntajes de riesgo >= 75 - sospechoso - generalmente debido a patrones asociados con
                                    enlaces
                                    maliciosos.
                                </div>
                                <span class="badge bg-danger rounded-pill">75</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    Puntuaciones de riesgo >= 85 - alto riesgo - gran confianza en que la URL es maliciosa.
                                </div>
                                <span class="badge bg-danger rounded-pill">85</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    Puntajes de riesgo = 100 + Phishing o Malware: indica malware confirmado o actividad de
                                    phishing en las
                                    últimas 24 a 48 horas.
                                </div>
                                <span class="badge bg-danger rounded-pill">100</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    Las URL sospechosas marcadas con Sospechoso indicarán dominios con una alta probabilidad
                                    de estar
                                    involucrados en un comportamiento abusivo.
                                </div>
                            </li>
                        </ol>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-sm btn-primary float-end" data-bs-toggle="modal"
                            data-bs-target="#modalCategory">
                            <i class="uil-info-circle"></i>
                            Categorías
                        </button>
                    </div>
                </div>

                <!-- Modal: Categorías -->
                <div class="modal fade" id="modalCategory" tabindex="-1" role="dialog"
                    aria-labelledby="modalCategoryLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header modal-colored-header bg-info">
                                <h5 class="modal-title" id="modalCategoryLabel">Categorías</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ol class="list-group list-group-numbered shadow">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Inseguro:</div>
                                            Sospecha de dominio no es seguro debido a suplantación de identidad, malware,
                                            spam o comportamiento
                                            abusivo.
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Sospechoso:</div>
                                            Sospecha de URL maliciosa o se usa para phishing.
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Suplantación de identidad:</div>
                                            URL asociada con un comportamiento de phishing malicioso.
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Malware:</div>
                                            URL está asociada con malware o virus.
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Email temporal:</div>
                                            URL actualmente estacionado con un aviso de venta.
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Spam:</div>
                                            Dominio de URL asociado con correo electrónico SPAM o direcciones de correo
                                            electrónico abusivas.
                                        </div>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal: Categorías -->
            </div>
        </div>
    </div>
</template>
<script>

import toastMixin from "../mixins/toastMixin.js"
import * as XLSX from 'xlsx'

export default {

    mixins: [toastMixin],

    data() {
        return {
            domains: '',
            responses: [],
            apiUrl: '/api/domain/list',
            isFetching: false,
            fetchProgress: 0,
            showTable: false,
            currentPage: 1,
            pageSize: 5,
            score: 0,
            credits: 0,
            loading: false
        }
    },

    computed: {
        totalPages() {
            return Math.ceil(this.responses.length / this.pageSize)
        },
        paginatedResponses() {
            const startIndex = (this.currentPage - 1) * this.pageSize
            const endIndex = startIndex + this.pageSize
            return this.responses.slice(startIndex, endIndex)
        }
    },

    methods: {
        async fetchDomains() {

            if (!this.domains || this.domains.trim() === '') {
                this.showToast("Por favor, introduce los Dominios", {
                    type: "warning"
                })
                return
            }
            const domainArray = this.domains.split('\n')
            if (domainArray.length > 10) {
                this.showToast("Por favor, introduce hasta 100 Dominios", {
                    type: "warning"
                })
                return
            }
            this.responses = [];
            this.isFetching = true;
            this.fetchProgress = 0;
            this.showTable = false;
            this.loading = true;
            this.currentPage = 1;

            const totalDomains = domainArray.length;
            let completedDomains = 0;

            for (const domain of domainArray) {

                const trimmedDomain = domain.trim();

                if (trimmedDomain.length > 0 && this.isValidDomain(trimmedDomain)) {
                    try {

                        const response = await axios.get(this.apiUrl, {
                            params: { domain: trimmedDomain }
                        });

                        this.responses.push(response.data.data);
                        this.credits = response.data.credits;

                    } catch (error) {
                        console.error(`Error al buscar el Dominio: ${trimmedDomain}`, error);
                        this.showToast("Error al buscar el Dominio", { type: "error" });
                    }
                } else {
                    console.error('Ingrese un dominio valido')
                }

                completedDomains++
                this.fetchProgress = Math.round((completedDomains / totalDomains) * 100)
            }

            if (!this.responses.length) {
                this.showToast("No se encontró información, revise sus datos", { type: "error" });
                this.isFetching = false;
                this.loading = false;
            } else {
                setTimeout(() => {
                    this.isFetching = false;
                    this.showTable = true;
                    this.loading = false;
                    this.showToast("Se cargaron los datos", { type: "success" });
                }, 2000);
            }
        },

        isValidDomain(domain) {
            const domainRegex = /^(?!:\/\/)([a-zA-Z0-9-_]+\.)*[a-zA-Z0-9][a-zA-Z0-9-_]+\.[a-zA-Z]{2,}$/;
            return domainRegex.test(domain);
        },

        exportToExcel() {
            const worksheet = XLSX.utils.json_to_sheet(this.responses)
            const workbook = XLSX.utils.book_new()
            XLSX.utils.book_append_sheet(workbook, worksheet, 'domains')
            const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' })
            const fileName = `domains_${this.getCurrentTime()}.xlsx`
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
        },

        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page
            }
        },

        getScoreBadge(score) {
            return (
                (score >= 0 && score < 25 ? '<span class="badge bg-primary">Very Low</span> ' : '') +
                (score >= 25 && score < 50 ? '<span class="badge bg-success">Low</span> ' : '') +
                (score >= 50 && score < 75 ? '<span class="badge bg-info">Medium</span> ' : '') +
                (score >= 75 && score < 85 ? '<span class="badge bg-warning">High</span> ' : '') +
                (score >= 85 && score <= 100 ? '<span class="badge bg-danger">Very High</span> ' : '')
            );
        },
    },
}
</script>
