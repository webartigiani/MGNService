<template>
    <!-- Modal Viewer  -->
    <div class="modal fade modal-fullscreen"
        v-if="item !== null"
        id="modalTracking"
        tabindex="-1" role="dialog"
        aria-labelledby="modalTracking"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- header -->
                <div class="modal-header">
                    <i class="fa fa-dot-circle mt-2 mr-2"
                        :title="(item.session_status==1 ? 'in corso' : 'conclusa')"
                        :class="(item.session_status==1 ? 'green' : 'orange')"></i>
                    <h5 class="modal-title">Dettagli Tragitto #{{ item.id }}: {{ item.nome }} {{ item.cognome }}, {{ item.start_date_time.substring(0, 10) }}</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- OpenStreetMap: creates the map with polyline -->
                    <v-map style="height: 100%"
                        :zoom="mapSettings.zoom"
                        :center="mapData.center"
                    >
                        <v-tilelayer :url="mapSettings.url"></v-tilelayer>

                        <!-- polyline -->
                        <v-polyline-decorator
                            :paths="mapData.polyline.latlngs"
                            :patterns="patterns"
                            :color="mapSettings.color"
                        ></v-polyline-decorator>

                        <!-- start marker with options -->
                        <v-marker
                            :lat-lng="mapData.startMarker"
                            :icon="mapSettings.startPoint"
                            >
                            <v-tooltip :options="mapSettings.markerToolTipOptions">Partenza: {{ item.start_date_time }} {{ addresses.startPoint }}</v-tooltip>
                        </v-marker>
                        <!-- end marker with options -->
                        <v-marker
                            :lat-lng="mapData.endMarker"
                            :icon="mapSettings.endPoint"
                            >
                            <v-tooltip :options="mapSettings.markerToolTipOptions">Arrivo: {{ item.end_date_time }} {{ addresses.endPoint }} </v-tooltip>
                        </v-marker>
                        <v-polyline :lat-lngs="mapData.polyline.latlngs" :color="mapSettings.color"></v-polyline>
                    </v-map>
                </div>

                <div class="row no-gutters mb-2">
                  <div class="col-lg-4 pl-3">
                    <small>
                      <b>Partenza:</b> {{ item.start_date_time }} {{ addresses.startPoint }}<br>
                      <b>{{ item.end_date_time!== null ? 'Arrivo' : 'Ultimo Rilevamento' }}:</b> {{ item.end_date_time!== null ? item.end_date_time : '' }} {{ addresses.endPoint }}<br>
                      <b>Durata:</b> {{ item.duration!==null ? item.duration : 'non ancora disponibile' }}
                    </small>
                  </div>
                  <div class="col-lg-3">
                    <small>
                      <b>Veicolo:</b> {{ item.veichle_manufacter }} {{ item.veichle_model }} ({{ item.veichle_licence_plate }})<br>
                      <b>Dispositivo:</b> {{ item.device_manufacter }} {{ addresses.device_model }} ({{ item.device_platform }} {{ item.device_version }})<br>
                      <b>Versione APP:</b> {{ item.device_app_version }}
                    </small>
                  </div>
                  <div class="col-lg-3">
                    <small>
                      <b>Sessione:</b> #{{ item.id }}<br>
                      <b>ID Sessione:</b> {{ item.session_id }}
                    </small>
                  </div>
                  <div class="col-lg-2 text-right">
                      <button type="button" class="btn btn-secondary mr-3" data-dismiss="modal">Chiudi</button>
                  </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* modal-fullscreen */
.modal.modal-fullscreen .modal-dialog {
  width: 100vw;
  height: 100vh;
  margin: 0;
  padding: 0;
  max-width: none;
}

.modal.modal-fullscreen .modal-content {
  height: auto;
  height: 100vh;
  border-radius: 0;
  border: none;
}

.modal.modal-fullscreen .modal-body {
  overflow-y: auto;
}
</style>

<script>
import VueTagsInput from '@johmun/vue-tags-input';
import Vue from 'vue'

/* OpenStreetMap VueJS.
    components  https://vue2-leaflet.netlify.app/components/
    examples    https://vue2-leaflet.netlify.app/examples/

    Other Plugins:
    - vue2-leaflet-polylinedecorator
        to decorate paths with arrows
        see https://www.npmjs.com/package/vue2-leaflet-polylinedecorator

    - vue2-leaflet-routing-machine
        see https://github.com/giordanna/vue2-leaflet-routing-machine/blob/master/src/components/LRoutingMachine.vue
*/
import L from "leaflet";
import { latLng, icon } from "leaflet";
//import { LMap, LTileLayer, LMarker, LPopup, LTooltip, LPolyline } from "vue2-leaflet";
import * as Vue2Leaflet from "vue2-leaflet";
import 'leaflet/dist/leaflet.css';
import Vue2LeafletPolylineDecorator from 'vue2-leaflet-polylinedecorator'
import { IRouter, IGeocoder, LineOptions } from 'leaflet-routing-machine'

Vue.component('v-polyline-decorator', Vue2LeafletPolylineDecorator)

export default {
    components: {
        VueTagsInput,

        // OpenStreetMap VueJS
        'v-map': Vue2Leaflet.LMap,
        'v-tilelayer': Vue2Leaflet.LTileLayer,
        'v-marker': Vue2Leaflet.LMarker,
        'v-tooltip': Vue2Leaflet.LTooltip,
        'v-polyline': Vue2Leaflet.LPolyline
    },

    // #region Properties
    data () {
        return {
            mapProvider: process.env.MIX_MAP_PROVIDER.toLowerCase(),
            // OpenStreet Map Data
            mapData: {
                center: [0,0],
                startMarker: [0,0],
                endMarker: [0,0],
                polyline: {
                    latlngs: [[0,0],[0,0]]
                },
            },
            // OpenStreet Map Settings
            mapSettings: {
                url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                zoom: 16,
                color: '#777777',
                // markers tooltip options
                markerToolTipOptions: {
                    permanent: false,
                    opacity: .75
                },
                // markers custom icons
                // see: https://iconarchive.com/search?q=map+marker
                startPoint: icon({
                    iconUrl: "https://icons.iconarchive.com/icons/icons-land/vista-map-markers/256/Map-Marker-Ball-Right-Chartreuse-icon.png",
                    iconSize: [48, 48],
                    iconAnchor: [32, 32]
                }),
                endPoint: icon({
                    iconUrl: "https://icons.iconarchive.com/icons/icons-land/vista-map-markers/256/Map-Marker-Ball-Right-Pink-icon.png",
                    iconSize: [48, 48],
                    iconAnchor: [32, 32]
                })
            },
            patterns: [{
                offset: 50,              /* position of first arrow */
                repeat: 150,             /* dist between arrows */
                symbol: L.Symbol.arrowHead({        // Define the arrow symbol
                    pixelSize: 8,      // Size
                    polygon: true,     // false: ^ shape, true: triangle shape.
                    pathOptions: {stroke: true, color:'#777777'}// Required to actually draw the arrow
                })
            }],
            addresses: {                // start-end address from  nominatim.org reverse API
                startPoint: '',         // see: https://nominatim.org/release-docs/latest/api/Reverse/
                endPoint: ''
            },
            item: null,
            rendering: 0
        }
    },
    filters: {
    },
    computed: {
    },
    // #endregion Properties

    // #region Methods
    methods: {
        show(item) {
            this.item = item
            axios.get('api/tracking/' + item.id, {}).then(({ data }) => {
                if (data.success) {
                    this.mapData.startMarker = data.data.start
                    this.mapData.endMarker = data.data.end
                    this.mapData.center = data.data.start
                    this.mapData.polyline.latlngs = data.data.latlngs

                    $('#modalTracking').modal('show')
                    setTimeout(function() {
                        // IMPORTANT: delayed resize event is required to make the map fit the modal!
                        window.dispatchEvent(new Event('resize'))
                    }, 250);

                    // gets starting and end point addresses
                    this.reversePoints(data)
                } else {
                    Swal.fire({
                        title: 'Ops!',
                        icon:'warning',
                        html: "Si è verificato un errore durante il caricamento dei dati del tragitto. Prego, riprova più tardi.<br><br>Se il problema persiste, contatta il supporto tecnico.",
                    });
                }
            }).catch((data)=> {
                // API Error
                Swal.fire({
                    title: 'Ops!',
                    icon:'warning',
                    html: "Si è verificato un errore durante il caricamento dei dati del tragitto. Prego, riprova più tardi.<br><br>Se il problema persiste, contatta il supporto tecnico.",
                });
            });
        },

        // #region Geo-Coding API
        reversePoints: async function(data) {
            let self = this
            let url = ''

            // reverese Starting Point
            url = 'https://nominatim.openstreetmap.org/reverse?lat=' + data.data.start[0] + '&lon=' + data.data.start[1] + '&format=json'
            axios.get(url, {}).then(({ data }) => {
                const { road, house_number, town, county } = data.address

                self.addresses.startPoint = `${road !== undefined ? road + ' ' : ''}
                ${house_number !== undefined ? house_number + ' ' : ''}
                ${town !== undefined ? town + ' ' : ''}
                ${county !== undefined ? '(' + county + ')' : ''}`.trim()
            })

            // reverese Arriving Point
            url = 'https://nominatim.openstreetmap.org/reverse?lat=' + data.data.end[0] + '&lon=' + data.data.end[1] + '&format=json'
            axios.get(url, {}).then(({ data }) => {
                const { road, house_number, town, county } = data.address

                self.addresses.endPoint = `${road !== undefined ? road + ' ' : ''}
                ${house_number !== undefined ? house_number + ' ' : ''}
                ${town !== undefined ? town + ' ' : ''}
                ${county !== undefined ? '(' + county + ')' : ''}`.trim()
            })
        },
        // #endregion Geo-Coding API
    },
    // #region Methods

    // #region Component Life Cycle
    beforeCreate() {
    },
    created() {
    },
    beforeMount() {
    },
    mounted() {
    },
    beforeDestroy() {
    },
    destroyed() {
    }
    // #endregion Component Life Cycle
}
</script>
