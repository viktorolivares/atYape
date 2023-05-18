<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">IP</a></li>
                            <li class="breadcrumb-item active">Consulta de IP</li>
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
                            Introduce las IPs
                        </span>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" v-model="ips" rows="10"></textarea>
                        <button class="btn btn-primary mt-3" :disabled="isFetching" @click.prevent="fetchIps">
                            {{ isFetching ? 'Consultando...' : 'Buscar IPs' }}
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
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <span class="mdi mdi-information"></span>
                            <strong>&nbsp; Ipapi (https://ipapi.co/)</strong>
                            proporciona una API REST para ubicar direcciones IP, ofreciendo información detallada como
                            ciudad, país, latitud, longitud, idiomas y más.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                disabled></button>
                        </div>
                    </div>
                    <div class="card-body" v-if="showTable && !isFetching">
                        <button class="btn btn-sm btn-success float-end mb-2" @click="exportToExcel">
                            .xlsx
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
                            <tbody>
                                <tr v-for="(data, index) in paginatedResponses" :key="index">
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ data.ip }}</td>
                                    <td>{{ data.country_name }}</td>
                                    <td>
                                        <img v-if="data.country_code && flagImages[data.country_code]"
                                            :src="flagImages[data.country_code]" :alt="data.country_name + ' Flag'"
                                            width="30">
                                    </td>
                                    <td>{{ data.region }}</td>
                                    <td>{{ data.city }}</td>
                                    <td>
                                        <a href="#" @click.prevent="openModal(data.latitude, data.longitude)"
                                            data-bs-toggle="modal" data-bs-target="#mapModal">Ver Mapa</a>
                                    </td>
                                    <td>{{ data.org }}</td>
                                </tr>
                            </tbody>
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
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <!-- Modal -->
            <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mapModalLabel">Mapa Incrustado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <Map :latitude="modalLatitude" :longitude="modalLongitude" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import toastMixin from "../mixins/toastMixin.js";
import Json from "../utils/flag.json"
import Map from "./map.vue";
import * as XLSX from 'xlsx';

export default {

    mixins: [toastMixin],
    components: { Map },

    data() {
        return {
            ips: '',
            responses: [],
            flagImages: {},
            apiUrl: '/api/ip',
            isFetching: false,
            fetchProgress: 0,
            showTable: false,
            currentPage: 1,
            pageSize: 5,
            modalLatitude: null,
            modalLongitude: null
        }
    },
    computed: {
        totalPages() {
            return Math.ceil(this.responses.length / this.pageSize);
        },
        paginatedResponses() {
            const startIndex = (this.currentPage - 1) * this.pageSize;
            const endIndex = startIndex + this.pageSize;
            return this.responses.slice(startIndex, endIndex);
        }
    },
    methods: {
        async fetchIps() {

            if (!this.ips || this.ips.trim() === '') {
                this.showToast("Por favor, introduce las IPs", {
                    type: "warning"
                });
                return;
            }

            const ipArray = this.ips.split('\n')
            if (ipArray.length > 100) {
                this.showToast("Por favor, introduce hasta 100 IPs", {
                    type: "warning"
                });
                return
            }

            this.responses = []
            this.isFetching = true
            this.fetchProgress = 0
            this.showTable = false

            const totalIps = ipArray.length
            let completedIps = 0

            for (const ip of ipArray) {
                const trimmedIp = ip.trim()
                if (trimmedIp.length > 0 && this.isValidIp(trimmedIp)) {
                    try {
                        const response = await axios.get(this.apiUrl, {
                            params: { ip: trimmedIp }
                        })
                        this.responses.push(response.data.data)
                    } catch (error) {
                        console.error(`Error al buscar la IP: ${trimmedIp}`, error)
                    }
                } else {
                    console.error('Ingrese una dirección valida')
                }

                completedIps++
                this.fetchProgress = Math.round((completedIps / totalIps) * 100);
            }

            console.log(this.responses)

            setTimeout(() => {
                this.isFetching = false
                this.showTable = true
                this.showToast("Se cargaron los datos", {
                    type: "success"
                });
            }, 2000);

        },

        isValidIp(ip) {
            const ipRegex = /^((25[0-5]|2[0-4][0-9]|[01]?[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9]{1,2})$/g
            return ipRegex.test(ip)
        },

        exportToExcel() {
            const worksheet = XLSX.utils.json_to_sheet(this.responses);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, 'ips');
            const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
            const fileName = `ips_${this.getCurrentTime()}.xlsx`;
            this.saveExcelFile(excelBuffer, fileName);
        },

        saveExcelFile(buffer, fileName) {
            const data = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(data);
            link.download = fileName;
            link.click();
        },

        getCurrentTime() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            return `${hours}${minutes}${seconds}`;
        },

        getFlags() {
            for (const item of Json) {
                this.flagImages[item.code] = item.image;
            }
        },

        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },

        openModal(latitude, longitude) {
            this.modalLatitude = latitude;
            this.modalLongitude = longitude;
        }
    },
    mounted() {
        this.getFlags();

    },


}
</script>
