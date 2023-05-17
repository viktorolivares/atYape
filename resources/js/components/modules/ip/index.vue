

    <template>
        <div>
          <div class="row">
            <div class="col-12">
              <div class="page-title-box">
                <h4 class="page-title">Búsqueda de IP masiva</h4>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 offset-md-3">
              <div class="card">
                <div class="card-body">
                  <form @submit.prevent="searchIP">
                    <div class="mb-3">
                      <label for="ipTextarea" class="form-label">Ingresar direcciones IP (una por línea)</label>
                      <textarea class="form-control" id="ip" rows="15" v-model="ipAddresses"></textarea>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="row" v-if="searchResults.length > 0">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Resultados de la búsqueda</h5>
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Dirección IP</th>
                        <th>País</th>
                        <th>Región</th>
                        <th>Ciudad</th>
                        <th>Proveedor de Internet</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="result in searchResults" :key="result.ip">
                        <td>{{ result.ip }}</td>
                        <td>{{ result.country }}</td>
                        <td>{{ result.region }}</td>
                        <td>{{ result.city }}</td>
                        <td>{{ result.isp }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>



<script>
export default {
    data() {
        return {
            ipResults: [],
            searchResults: [],
            progressBarWidth: 0,
        };
    },
    methods: {
        searchIP() {

            this.ipResults = [];

            const ipInput = this.$refs.ip.value;
            const ip = ipInput.split(/\n/).filter(Boolean);

            if (ip.length <= 100) {
                let progress = 0;

                for (let i = 0; i < ip.length; i++) {
                    const currentIP = ip[i];

                    this.makeAPIRequest(currentIP)
                        .then((data) => {
                            const ipData = {
                                ip: currentIP,
                                data: data.data,
                                flag: null,
                            };

                            if (data.data.error === true) {
                                ipData.data.reason = '-';
                            } else {
                                this.getFlag(currentIP, data.data.country)
                                    .then((flagUrl) => {
                                        ipData.flag = flagUrl;
                                    })
                                    .catch((error) => {
                                        console.error('Error fetching flag:', error);
                                    });
                            }

                            this.ipResults.push(ipData);

                            progress += 1;
                            this.progressBarWidth = Math.floor((progress / ip.length) * 100);

                            if (progress === ip.length) {
                                this.$refs.progress.style.display = 'none';
                                this.$refs.btnExcel.style.display = 'block';
                                this.$refs.tableIp.style.display = 'block';
                            }
                        })
                        .catch((error
                        ) => {
                            console.error('Error fetching IP data:', error);
                        });
                }
            } else {
                alert('Máximo 100 consultas');
            }
        },
        makeAPIRequest(ip) {
            return new Promise((resolve, reject) => {
                const url = `/ip-consult/${ip}`;
                this.$axios
                    .get(url)
                    .then((response) => {
                        resolve(response.data);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        getFlag(ip, countryCode) {
            return new Promise((resolve, reject) => {
                this.$axios
                    .get('js/flag.json')
                    .then((response) => {
                        const flags = response.data;
                        const flag = flags.find((item) => item.code === countryCode);
                        if (flag) {
                            resolve(flag.image);
                        } else {
                            resolve(null);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        exportToExcel() {
            this.$refs.tableIp.table2excel({
                filename: `ip-${Date.now()}.xls`,
                preserveColors: true,
            });
        },
        showMap(latitude, longitude, city) {
            this.$refs.viewMaps.style.display = 'block';

            const map = L.map('map').setView([latitude, longitude], 14);

            setTimeout(() => {
                map.invalidateSize();
            }, 100);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                minZoom: 2,
                attribution: '© OpenStreetMap',
            }).addTo(map);

            L.marker([latitude, longitude])
                .addTo(map)
                .bindPopup(`${city}<br>${latitude}, ${longitude}`)
                .openPopup();
        },
    },
};
</script>
