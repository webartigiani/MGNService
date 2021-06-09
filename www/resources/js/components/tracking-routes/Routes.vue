<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <h3>Tragitti</h3>

            <div class="card">
                <div class="card-header">
                    <div class="card-title col-9 filters">
                        <select name="per_page" id="per_page"
                            class="form-control"
                            v-model="filters.per_page"
                            @change="list()"
                            >
                            <option value="10">10 per pagina</option>
                            <option value="25">25 per pagina</option>
                            <option value="50">50 per pagina</option>
                        </select>
                    </div>
                    <!-- tools -->
                    <div class="card-tools col-3 text-right">
                        <!-- filters toggler -->
                        <button type="button"
                            class="btn btn-sm"
                            title="Mostra/Nascondi Filtri"
                            @click="filters.show = !filters.show"
                            >
                            <i class="fas fa-sort-down" v-show="!filters.show"></i>
                            <i class="fas fa-sort-up" v-show="filters.show"></i>
                        </button>
                    </div>
                </div>

                <!-- filters -->
                <transition name="slide">
                <div class="card-header filters"
                    v-show="filters.show"
                    >
                    <h6><i class="fas fa-filter"></i> Filtri</h6>
                    <div class="card-title col-12">
                        <div class="row">
                            <div class="col-10">
                                <input
                                    v-model="filters.date_start"
                                    type="date"
                                    id="date_start"
                                    class="form-control"
                                    :min="`2019-01`"
                                    :max="$root.utils.datetime.formatDateISO(new Date())"
                                    @change="list()"
                                    title="Inizio Periodo"
                                />
                                <input
                                    v-model="filters.date_end"
                                    type="date"
                                    class="form-control"
                                    :min="`2019-01`"
                                    :max="$root.utils.datetime.formatDateISO(new Date())"
                                    @change="setPeriod(); list()"
                                    title="Fine Periodo"
                                />

                            </div>
                            <div class="col-2 text-right">
                                <label for="status">Stato</label>
                                <select name="status" id="status"
                                    class="form-control"
                                    v-model="filters.status"
                                    @change="list()"
                                    >
                                    <option value="-1">-- qualunque --</option>
                                    <option value="1">in corso</option>
                                    <option value="0">conclusa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                </transition>

              <!-- body -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead
                    v-show="items.data.length > 0"
                    >
                    <tr>
                      <th></th>
                      <!-- <th>ID</th> -->
                      <th>Partenza</th>
                      <th>Arrivo</th>
                      <th>Durata</th>
                      <!-- <th></th> -->
                      <th>Dipendente</th>
                      <th>Veicolo</th>
                      <th>Dispositivo</th>
                      <th>Azioni</th>
                    </tr>
                  </thead>
                  <tbody
                    v-show="items.data.length > 0"
                    >
                     <tr v-for="item in items.data" :key="item.id">
                        <td style="width:20px;">
                            <i class="fa fa-dot-circle"
                                :title="(item.anomaly==1 ? 'in corso' : 'conclusa')"
                                :class="(item.anomaly==1 ? 'green' : 'orange')"></i>
                        </td>
                        <!-- <td>{{ item.id }}</td> -->
                        <td>{{ $root.utils.datetime.formatDateTime(item.start_date_time) }}</td>
                        <td>{{ $root.utils.datetime.formatDateTime(item.end_date_time) }}</td>
                        <td>{{ item.duration }}</td>
                        <!--
                        <td style="width:20px;">
                            <i class="fas fa-exclamation-triangle red"
                                v-show="item.anomaly == 1"
                                title="Anomalie nel tragitto"
                            ></i>
                        </td>
                        -->
                        <td>
                            <i class="fa fa-dot-circle"
                                :title="(item.worker_status==1 ? 'attualmente presente' : 'attualmente assente')"
                                :class="(item.worker_status==1 ? 'green' : 'orange')"></i>
                            {{ item.nome }} {{ item.cognome }}
                        </td>
                        <td>
                            <i class="fa fa-dot-circle"
                                :title="(item.veichle_status==1 ? 'attualmente in strada' : 'in rimessa')"
                                :class="(item.veichle_status==1 ? 'green' : 'orange')"></i>
                            {{ item.veichle_manufacter }} {{ item.veichle_model }} ({{ item.veichle_licence_plate }})
                        </td>
                        <td>
                            <i class="fa fa-dot-circle"
                                :title="(item.device_online==1 ? 'attualmente online' : 'attualmente offline')"
                                :class="(item.device_online==1 ? 'green' : 'orange')"></i>
                            {{ item.device_manufacter }} {{ item.device_model }} ({{ item.device_platform }} {{ item.device_version }})</td>
                        </td>

                        <td>
                            <a href="#"
                                class="action"
                                title="Visualizza Tragitto"
                                @click="viewModal(item)"
                                >
                                <i class="fas fa-eye blue"></i>
                            </a>
                            <a href="#"
                                class="action"
                                title="Elimina questo tracciamento"
                                @click="deleteItem(item)"
                                >
                                <i class="fa fa-trash blue"></i>
                            </a>
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- footer -->
              <div class="card-footer"
                v-show="items.data.length > 0"
                >
                  <!-- see pagination componenet https://www.npmjs.com/package/laravel-vue-pagination -->
                  <pagination
                    :data="items" @pagination-change-page="getResults"
                    :limit=10
                  ></pagination>
              </div>
            </div>
            <!-- /.card -->

            <!-- no data -->
            <h3 class="text-center"
            v-show="items.data.length == 0"
            >
                Non ci sono dati nel periodo selezionato</h3>
          </div>
        </div>

    <!-- Modal Viewer  -->
        <div class="modal fade modal-fullscreen" id="modalTracking" tabindex="-1" role="dialog" aria-labelledby="modalTracking" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Dettagli Tragitto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- creates the map with polyline -->
                        <l-map style="height: 500px"
                            :zoom="mapSettings.zoom"
                            :center="mapData.center"
                        >
                            <l-tile-layer :url="mapSettings.url"></l-tile-layer>
                            <!-- start marker with options -->
                            <l-marker
                                :lat-lng="mapData.startMarker"
                                :icon="mapSettings.carIcon"
                                >
                                <l-tooltip :options="mapSettings.markerToolTipOptions">Partenza</l-tooltip>
                            </l-marker>
                            <!-- end marker with options -->
                            <l-marker
                                :lat-lng="mapData.endMarker"
                                :icon="mapSettings.carIcon"
                                >
                                <l-tooltip :options="mapSettings.markerToolTipOptions">Arrivo</l-tooltip>
                            </l-marker>
                            <l-polyline :lat-lngs="mapData.polyline.latlngs" :color="mapSettings.color"></l-polyline>
                        </l-map>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
</template>

<style scoped>
a.action {
    margin-right:5px!important;
}
.btn-green, .btn-green:focus, .btn-green:active {
    /* overwrite some styles */
    background-color: #38c172!important;
    border-color: #38c172!important;
}
textarea.notes {
  resize: none;
}

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
*/
import { latLng, icon } from "leaflet";
import { LMap, LTileLayer, LMarker, LPopup, LTooltip, LPolyline } from "vue2-leaflet";
import 'leaflet/dist/leaflet.css'

export default {
    components: {
        VueTagsInput,

        // OpenStreetMap VueJS
        LMap,
        LTileLayer,
        LMarker,
        LPopup,
        LTooltip,
        LPolyline
    },

    // #region Properties
    data () {
        return {
            items : {},
            // filters
            filters: {
                show: false,
                date_start: null,
                date_end: null,
                status: -1,
                per_page: 50
            },
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
                zoom: 20,
                color: 'red',
                // markers tooltip options
                markerToolTipOptions: {
                    permanent: true,
                    opacity: 0.2
                },
                // markers custom icons
                carIcon: icon({
                    iconUrl: "https://image.flaticon.com/icons/png/512/65/65578.png",
                    iconSize: [32, 32],
                    iconAnchor: [16, 32]
                }),
            }
        }
    },
    filters: {
    },
    computed: {
    },
    // #endregion Properties

    // #region Methods
    methods: {
        getResults(page = 1) {
            this.$Progress.start();
            let params = this.filters                           // appends filters and search
            params.query = this.$root.$route.query.search
            axios.get('api/tracking?page=' + page, {
                params: params
            }).then(({ data }) => (this.items = data.data));
            this.$Progress.finish();
        },

        // #region Modals
        viewModal(item) {
            this.$Progress.start();
            axios.get('api/tracking/' + item.id, {}).then(({ data }) => {

                if (data.success) {
                    this.mapData.status = data.data.start
                    this.mapData.endMarker = data.data.end
                    this.mapData.center = data.data.start
                    this.mapData.polyline.latlngs = data.data.latlngs

                    $('#modalTracking').modal('show');
                    setTimeout(function() {
                        window.dispatchEvent(new Event('resize'))
                        this.$Progress.finish()
                    }, 250);
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
        // #endregion Modals

        // #region CRUD Functions
        list() {
            this.$Progress.start();
            this.checkFilters()
            let params = this.filters                           // appends filters and search
            params.query = this.$root.$route.query.search
            axios.get('api/tracking', {
                params: params
            }).then(({ data }) => (this.items = data.data, this.$Progress.finish()));
        },
        deleteItem(item) {
            const msg = "Eliminare le timbrate giornaliere del dipendente?<br><br>Il dipendente<br>" + item.nome + " " + item.cognome + "<br>risulterà assente in data " + item.day_date + "<br><br>Attenzione: questa operazione è irreversibile.";

            Swal.fire({
                title: 'Conferma',
                icon:'question',
                html: msg,
                showCancelButton: true,
                confirmButtonText: 'Si, elimina',
                cancelButtonText: 'Annulla'
                }).then((result) => {
                    // Send request to the server
                    if (result.value) {
                        this.form.delete('api/attendance/' + item.id).then(()=>{
                            Swal.fire(
                                'Timbrate Eliminate!',
                                'Timbrate correttamente eliminate.',
                                'success'
                            );
                            // Fire.$emit('AfterCreate');
                            this.list();
                        }).catch((data)=> {
                            Swal.fire("Failed!", data.message, "warning");
                        });
                    }
                })
        },
        // #endregion CRUD Functions

        // #region Filters Functions
        checkFilters() {
            // sets default filters if NULL
            const now = new Date();
            const d = this.$root.utils.generic.padZero(now.getDate());
            const m = this.$root.utils.generic.padZero(now.getMonth() + 1);
            const y = now.getFullYear()

            if (this.filters.date_start == '') {
                this.filters.date_start = y + '-' + m + '-' + d;
                this.setPeriod()
            }
            if (this.filters.date_end == '') {
                this.filters.date_end = y + '-' + m + '-' + d;
                this.setPeriod()
            }

            // checks dates
            if (this.filters.date_start > this.filters.date_end) this.filters.date_end = this.filters.date_start
        },
        setCurrentMonth() {
            const now = new Date();
            const d = this.$root.utils.generic.padZero(now.getDate());
            const m = this.$root.utils.generic.padZero(now.getMonth() + 1);
            const y = now.getFullYear()

            this.filters.date_start = y + '-' + m + '-01';
            this.filters.date_end = y + '-' + m + '-' + d;
            this.filters.description = 'del mese corrente';
            this.list();
        },
        // #endregion Filters Functions

        // #region Utils
        presenzaString(item) {
            // returns presenza description
            console.log('presenzaString ' + item.worker_id, item)
            switch (item.chk) {
                case -1:
                    // assenza con giustificativo o giornata di riposo
                    switch (item.abscence_justification) {
                        case '_R': return 'riposo';
                        default: return 'assente';
                    }
                case 0: return 'incompleta';
                case 1: return 'presente';
            }
        },
        presenzaToClass(item) {
            // returns presenza class
            switch (item.chk) {
                case -1:
                    // assenza con giustificativo o giornata di riposo
                    switch (item.abscence_justification) {
                        case '_R': return 'badge-info';
                        default: return 'badge-danger';
                    }
                case 0: return 'badge-warning';
                case 1: return 'badge-success';
            }
        },
        assenzaToClass(item) {
            // returns presenza class
            switch (item.chk) {
                case -1:
                    // assenza con giustificativo o giornata di riposo
                    switch (item.abscence_justification) {
                        case '': return 'badge-danger';
                        case '_R': return 'badge-info';
                    }
                case 0: return 'badge-warning';
                case 1: return 'badge-warning';
            }
        },
        attendanceTime(dayDate, t) {
            if (t == null) return ''
            if (dayDate == '') return ''
            return t.replace(dayDate, '').trim()
        }
        // #endregion utils
    },
    // #region Methods

    // #region Component Life Cycle
    beforeCreate() {
    },
    created() {
        this.$Progress.start();
        this.setCurrentMonth()
        this.list();                    // lists presenze
        this.$Progress.finish();
    },
    beforeMount() {
    },
    mounted() {
        // sets search-query fron url
        this.$root.search.query = this.$root.$route.query.search
    },
    beforeDestroy() {
    },
    destroyed() {
    }
    // #endregion Component Life Cycle
}
</script>
