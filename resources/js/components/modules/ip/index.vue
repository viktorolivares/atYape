<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">IP</a></li>
                            <li class="breadcrumb-item active">Consulta de IPs</li>
                        </ol>
                    </div>
                    <h4 class="page-title">IP</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title font-14 text-primary">
                            IP's | Consulta máxima 100 registros
                        </span>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Máximo de consultas diarias: 1000</p>
                        <textarea class="form-control" v-model="ips" rows="10"></textarea>
                        <button class="btn btn-primary mt-3" :disabled="isFetching" @click.prevent="fetchIps">
                            <template v-if="isFetching">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            </template>
                            <template v-else>
                                <span class="mdi mdi-magnify"></span>
                                Buscar IPs
                            </template>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <transition name="fade">
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
                </transition>

                <div class="card">
                    <div class="px-3 pt-2">
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <span class="mdi mdi-information"></span>
                            <strong>&nbsp; Ipapi (https://ipapi.co/)</strong>
                            proporciona una API REST para ubicar direcciones IP, ofreciendo información detallada como
                            ciudad, país, latitud, longitud, idiomas y más.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                disabled></button>
                        </div>
                    </div>

                    <transition name="fade">
                        <div class="card-body" v-if="showTable && !isFetching">
                            <button class="btn btn-sm btn-success float-end mb-2" @click="exportToExcel">
                                <span class="mdi mdi-download"></span>
                                Exportar en excel
                            </button>

                            <table class="table table-sm table-bordered table-condensed table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">IP</th>
                                        <th scope="col">País</th>
                                        <th scope="col">Flag</th>
                                        <th scope="col">Región</th>
                                        <th scope="col">Ciudad</th>
                                        <th scope="col">Coordenadas</th>
                                        <th scope="col">Organización</th>
                                    </tr>
                                </thead>
                                <transition-group name="fade">
                                    <tbody>
                                        <tr v-for="(data, index) in paginatedResponses" :key="index">
                                            <th scope="row">{{ index + 1 }}</th>
                                            <td>{{ data.ip }}</td>
                                            <td>{{ data.country_name }}</td>
                                            <td>
                                                <img v-if="data.country_code && flagImages[data.country_code]"
                                                    :src="flagImages[data.country_code]" :alt="data.country_name + ' Flag'"
                                                    width="20" />
                                            </td>
                                            <td>{{ data.region }}</td>
                                            <td>{{ data.city }}</td>
                                            <td>
                                                <a href="#" @click.prevent="openMap(data.latitude, data.longitude)">Ver
                                                    Mapa</a>
                                            </td>
                                            <td>{{ data.org }}</td>
                                        </tr>
                                    </tbody>
                                </transition-group>
                            </table>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                                        <a class="page-link" href="#" @click.prevent="goToPage(1)">
                                            <i class="mdi mdi-arrow-bottom-left"></i>
                                        </a>
                                    </li>
                                    <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                                        <a class="page-link" href="#"
                                            @click.prevent="goToPage(currentPage - 1)">Anterior</a>
                                    </li>
                                    <li class="page-item" v-for="page in visiblePages" :key="page"
                                        :class="{ 'disabled': page === null, 'active': page === currentPage }">
                                        <a class="page-link" href="#"
                                            @click.prevent="goToPage(page)">{{ page === null ? '...' : page }}</a>
                                    </li>
                                    <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                                        <a class="page-link" href="#"
                                            @click.prevent="goToPage(currentPage + 1)">Siguiente</a>
                                    </li>
                                    <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                                        <a class="page-link" href="#" @click.prevent="goToPage(totalPages)">
                                            <i class="mdi mdi-arrow-bottom-left"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </transition>

                    <transition name="fade">
                        <div class="card-body" v-if="loading">
                            <div class="d-flex align-items-center">
                                <strong>Cargando...</strong>
                                <div class="spinner-border text-primary ms-auto" role="status" aria-hidden="true"></div>
                            </div>
                        </div>
                    </transition>
                </div>

                <transition name="slide-fade">
                    <div class="card" id="mapCard" v-if="mapCard">
                        <div class="card-body text-center">
                            <template v-if="isLoading">
                                <div class="d-flex align-items-center">
                                    <strong>Cargando...</strong>
                                    <div class="spinner-border text-success ms-auto" role="status" aria-hidden="true"></div>
                                </div>
                            </template>
                            <template v-else>
                                <Map :latitude="lat" :longitude="lng" />
                            </template>
                        </div>
                    </div>
                </Transition>
            </div>
        </div>
    </div>
</template>
<script>
import toastMixin from "../mixins/toastMixin.js"
import Json from "../utils/flag.json"
import Map from "./map.vue"
import * as XLSX from 'xlsx'

export default {
    mixins: [toastMixin],
    components: { Map },
    data() {
        return {
            ips: '',
            responses: [],
            flagImages: {},
            apiUrl: '/api/ip/query',
            isFetching: false,
            isLoading: false,
            loading: false,
            mapCard: false,
            fetchProgress: 0,
            showTable: false,
            currentPage: 1,
            pageSize: 5,
            lat: 10,
            lng: 20
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
        async fetchIps() {
            if (!this.ips || this.ips.trim() === '') {
                this.showToast("Por favor, introduce las IPs", {
                    type: "warning"
                })
                return
            }
            const ipArray = this.ips.split('\n')
            if (ipArray.length > 100) {
                this.showToast("Por favor, introduce hasta 100 IPs", {
                    type: "warning"
                })
                return
            }
            this.responses = [];
            this.isFetching = true;
            this.loading = true;
            this.mapCard = false;
            this.fetchProgress = 0;
            this.showTable = false;
            this.currentPage = 1;

            const totalIps = ipArray.length;
            let completedIps = 0;
            
            for (const ip of ipArray) {
                const trimmedIp = ip.trim()
                if (trimmedIp.length > 0 && this.isValidIp(trimmedIp)) {
                    try {
                        const response = await axios.get(this.apiUrl, {
                            params: { ip: trimmedIp }
                        });

                        if (response.status === 200) {
                            this.responses.push(response.data.data)
                        } else {
                            console.error(`Error al buscar la IP: ${trimmedIp}. Estado de la respuesta: ${response.status}`);
                            this.showToast("Error al buscar la IP", { type: "error" });
                        }
                    } catch (error) {
                        console.error(`Error al buscar la IP: ${trimmedIp}`, error);
                        this.showToast("Error al buscar la IP", { type: "error" });
                    }
                } else {
                    console.error('Ingrese una dirección válida')
                }

                completedIps++
                this.fetchProgress = Math.round((completedIps / totalIps) * 100)
            }

            if (!this.responses.length) {
                this.showToast("No se encontró información, revise sus datos", { type: "error" });
                this.isFetching = false;
                this.loading = false
            } else {
                setTimeout(() => {
                    this.isFetching = false;
                    this.showTable = true;
                    this.loading = false
                    this.showToast("Se cargaron los datos", { type: "success" });
                }, 2000);
            }

            console.log(this.responses)


        },
        isValidIp(ip) {
            const ipRegex = /^((25[0-5]|2[0-4][0-9]|[01]?[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9]{1,2})$/g
            return ipRegex.test(ip)
        },
        exportToExcel() {
            const worksheet = XLSX.utils.json_to_sheet(this.responses)
            const workbook = XLSX.utils.book_new()
            XLSX.utils.book_append_sheet(workbook, worksheet, 'ips')
            const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' })
            const fileName = `ips_${this.getCurrentTime()}.xlsx`
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
        getFlags() {
            for (const item of Json) {
                this.flagImages[item.code] = item.image
            }
        },
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page
            }
        },
        openMap(latitude, longitude) {
            if (latitude && longitude) {
                this.isLoading = true;
                this.lat = latitude;
                this.lng = longitude;
                this.mapCard = true;
                setTimeout(() => {
                    this.isLoading = false;
                }, 2000);
                console.log([this.lat, this.lng]);
            } else {
                this.showToast('Error: No se proporcionaron las coordenadas.', {
                    type: "error"
                })
            }
        }
    },
    mounted() {
        this.getFlags()
    }
}
</script>
