<template>
    <div>
        <div id="mapContainer"></div>
    </div>
</template>
<script>
import { defineComponent, onMounted, onBeforeUnmount, watch } from 'vue'
import 'leaflet/dist/leaflet.css'
import L from 'leaflet'

export default defineComponent({
    name: 'Map',
    props: {
        latitude: {
            type: Number,
            required: false,
            default: -12.0464
        },
        longitude: {
            type: Number,
            required: false,
            default: -77.0428
        }
    },
    setup(props) {

        let map = null
        let marker = null


        onMounted(() => {
            createMapLayer()
        })

        onBeforeUnmount(() => {
            if (map) {
                map.remove()
            }
        })

        watch(() => [props.latitude, props.longitude], () => {
            if (map) {
                map.setView([props.latitude, props.longitude], 15)
                if (marker) {
                    marker.setLatLng([props.latitude, props.longitude])
                } else {
                    marker = setMarkers(props.latitude, props.longitude)
                }
            }
        })

        const createMapLayer = () => {
            if (L && L.map && document.getElementById('mapContainer')) {
                map = L.map('mapContainer').setView([props.latitude, props.longitude], 15)
                L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map)

                marker = setMarkers(props.latitude, props.longitude)
            } else {
                console.error('Error: Leaflet library or map container element not found.')
            }
        }

        const setMarkers = (latitude, longitude) => {
            if (map) {
                return L.marker([latitude, longitude]).addTo(map)
            } else {
                console.error('Error: Map not initialized.')
            }
        }
    },

})

</script>
<style scoped>
#mapContainer {
    width: 100%;
    height: 100%;
    min-height: 50vh;
    max-height: calc(100vh - 500px);
}
</style>
