<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <h3>Tragitti {{ filters.description }}</h3>

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
                                <!-- filtri date -->
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

                                <!-- pulsanti impostazione filtri date -->
                                <button type="button"
                                    class="btn btn-sm btn-primary"
                                    title="Anno in corso"
                                    @click="setCurrentYear()">
                                    <i class="far fa-calendar"></i>
                                    365
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-primary"
                                    title="Mese Scorso"
                                    @click="setLastMonth()">
                                    <i class="fas fa-history"></i>
                                    30
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-primary btn-green"
                                    title="Mese in corso"
                                    @click="setCurrentMonth()">
                                    <i class="far fa-calendar"></i>
                                    30
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-primary"
                                    title="Settimana scorsa"
                                    @click="setLastWeek()">
                                    <i class="fas fa-history"></i>
                                    7
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-primary btn-green"
                                    title="Settimana in corso"
                                    @click="setCurrentWeek()">
                                    <i class="far fa-calendar"></i>
                                    7
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-primary"
                                    title="Ieri"
                                    @click="setYesterday()">
                                    <i class="fas fa-history"></i>
                                    Ieri
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-primary btn-green"
                                    title="Oggi"
                                    @click="setToday()">
                                    <i class="far fa-clock"></i>
                                    Oggi
                                </button>
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
                                    <option value="0">concluso</option>
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
                      <th>Dipendente</th>
                      <th>Veicolo</th>
                      <th>Dispositivo</th>
                      <th v-if="user_type === 'webmaster'">Punti</th>
                      <th>Azioni</th>
                    </tr>
                  </thead>
                  <tbody
                    v-show="items.data.length > 0"
                    >
                     <tr v-for="item in items.data" :key="item.id">
                        <td style="width:20px;">
                            <i class="fa fa-dot-circle"
                                :title="(item.session_status==1 ? 'in corso' : 'concluso')"
                                :class="(item.session_status==1 ? 'green' : 'orange')"></i>
                        </td>
                        <!-- <td>{{ item.id }}</td> -->
                        <td>{{ $root.utils.datetime.formatDateTime(item.start_date_time) }}</td>
                        <td>{{ $root.utils.datetime.formatDateTime(item.end_date_time) }}</td>
                        <td>{{ item.duration }}</td>
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
                            {{ item.device_manufacter }} {{ item.device_model }} ({{ item.device_platform }} {{ item.device_version }})
                        </td>
                        <td v-if="user_type === 'webmaster'">
                            {{ item.points }}
                        </td>
                        <td>
                            <a href="#"
                                class="action"
                                title="Visualizza Tragitto"
                                @click="viewRoute(item)"
                                >
                                <i class="fas fa-eye blue"></i>
                            </a>
                            <a href="#"
                                v-if="item.session_status==1"
                                class="action"
                                title="Interrompi questo tracciamento"
                                @click="deleteItem(item)"
                                >
                                <i class="far fa-stop-circle blue"></i>
                            </a>
                            <!-- aggiornamento richiesto se versione app device < last release -->
                            <a href="#"
                                v-if="item.device_app_version !== lastAppVersion"
                                class="action"
                                title="Aggiornamento App Richiesto"
                                @click="appUpgradeRequired(item)"
                                >
                                <i class="fas fa-exclamation-triangle red"></i>
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

        <!-- route QUI -->
        <route-component ref="RouteComponent"></route-component>

        <!-- vue-confirm-dialog -->
        <vue-confirm-dialog></vue-confirm-dialog>
    </div>
  </section>
</template>

<style>
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

/* vue-confirm-dialog */
div.vc-container {
    width: 640px!important;
}
</style>

<script>
import VueTagsInput from '@johmun/vue-tags-input';
import Vue from 'vue'

// Components
import RouteComponent from './RouteComponent'

export default {
    components: {
        VueTagsInput,
        RouteComponent
    },

    // #region Properties
    props: [
        'user_type'          // user property is the Laravel User object passed throught <router-view user_type="{{ Auth::user()->type }}"></router-view> in master.blade
    ],
    data () {
        return {
            mapProvider: process.env.MIX_MAP_PROVIDER.toLowerCase(),
            items : {},
            // filters
            filters: {
                show: false,
                date_start: null,
                date_end: null,
                status: -1,
                per_page: 50,
                description: ''
            },
            form: {
                id: '',
            },
            webMasterADV: {
                response: false,
                enable: false
            }
        }
    },
    computed: {
        lastAppVersion() {
            // returns the last APP release version number
            return process.env.MIX_APP_VERSION
        }
    },
    // #endregion Properties

    // #region Component Life Cycle
    beforeCreate() {
    },
    created() {
        this.$Progress.start();
        this.setCurrentMonth()  // imposta mese corrente e lista tragitti
        this.$Progress.finish();
    },
    beforeMount() {
    },
    mounted() {
        // sets search-query fron url
        console.clear()
        this.$root.search.query = this.$root.$route.query.search
    },
    beforeDestroy() {
    },
    destroyed() {
    },
    // #endregion Component Life Cycle

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
        viewRoute(item) {
            // open the specified route into the RouteComponent modal

            // if user is WebMaster, ask to use advanced functions
            if (this.user_type === 'webmaster') {
                if (this.webMasterADV.response) {
                    // ha già chiesto se abilitare le funzioni avanzate WebMaster
                    this.$refs.RouteComponent.show(item, this.webMasterADV.enable)  // opens map with/without WebMasterADV
                } else {
                    this.$confirm(
                    {
                        title: 'Funzioni Avanzate WebMaster',
                        message: `Poichè sei connesso come WebMaster, puoi abilitare le funzioni avanzate di navigazione: che ti consentono di visualizzare le coordinate di ogni punto raccolto, muovendoti sulla mappa. NOTA: le funzioni WebMaster avanzate possono rallentare il client. Per disattivarle, ricaricare la pagina e rispondere "Annulla" a questo messaggio.`,
                        button: {
                            no: 'Annulla',
                            yes: 'Si'
                        },
                        /**
                         * Callback Function
                         * @param {Boolean} confirm
                         */
                        callback: confirm => {
                            this.webMasterADV.response = true                               // we've got a response
                            if (confirm) this.webMasterADV.enable = true                    // we enable webMaster ADV
                            this.$refs.RouteComponent.show(item, this.webMasterADV.enable)  // opens map with/without WebMasterADV
                        }
                    })
                }
            } else {
                // other user type (open map without WebMasterADV)
                this.$refs.RouteComponent.show(item, false)
            }
        },
        deviceToUpgrade() {
            // returns the number of device to upgrade
            if (this.items.length === 0) return 0

            const obsoletes = this.items.data.filter((item) => { return item.device_app_version !== this.lastAppVersion })
            return obsoletes.length
        },

        // #region CRUD Functions
        list() {
            this.$Progress.start();
            this.checkFilters()
            let params = this.filters                           // appends filters and search
            params.query = this.$root.$route.query.search
            axios.get('api/tracking', {
                params: params
            }).then(({ data }) => {

                this.items = data.data
                console.log(this.items)
                this.$Progress.finish()

                // Checks if there's device to upgrade
                const devToUpgrade = this.deviceToUpgrade()

                if (devToUpgrade > 0) {
                    const msg = `Attenzione: ${devToUpgrade} tragitti sono stati acquisiti con dispositivi che non stanno eseguendo l'aggironamento automatico dell'App.<br><br>Si consiglia di aggiornare manualmente l'App alla versione ${this.lastAppVersion} su tutti i dispositivi in uso.<br><br>Per informazioni, cliccare il triangolo rosso in corrispondenva del tragitto.`;
                    Swal.fire({
                        title: 'Aggiornamenti Richiesti',
                        icon:'warning',
                        html: msg,
                        confirmButtonText: 'Ok',
                    })
                }
            });
        },
        deleteItem(item) {
            const msg = "Interrompere il tragitto in corso di<br>" + item.nome + " " + item.cognome + "<br>con " + item.veichle_manufacter + " " + item.veichle_model + " (" + item.veichle_licence_plate + ")?";
            Swal.fire({
                title: 'Conferma',
                icon:'question',
                html: msg,
                showCancelButton: true,
                confirmButtonText: 'Si, interrompi',
                cancelButtonText: 'Annulla'
                }).then((result) => {
                    // Send request to the server
                    if (result.value) {
                        axios.delete('api/tracking/' + item.session_id).then(()=>{
                            Swal.fire(
                                'Tragitto interrotto!',
                                'Tragitto correttamente interrotto.',
                                'success'
                            );
                            // Fire.$emit('AfterCreate');
                            this.list();
                        }).catch((data)=> {
                            console.log('data', data)
                            Swal.fire("Failed!", data.message, "warning");
                        });
                    }
                })
        },
        appUpgradeRequired(item) {
            const msg = `Il dispositivo ${item.device_manufacter} ${item.device_model} (${item.device_platform} ${item.device_version}) sta usando una <b>versione obsoleta dell'App, che non supporta l'aggiornamento automatico..<br><br><span>Per aggiornare manualmente il dispositivo alla versione ${this.lastAppVersion} dell'App:<br>- accedere a "Impostazioni/Installa APP" su questo sito<br>- scansionare il QRCode con la fotocamera del dispositivo<br>- seguire la procedura di download e installazione dell'App sul telefono.</span>`;
            Swal.fire({
                title: 'Aggiornamento Richiesto',
                icon:'warning',
                html: msg,
                confirmButtonText: 'Ok',
                customClass: 'swal-wide',
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
        setToday() {
            const now = new Date();
            const d = this.$root.utils.generic.padZero(now.getDate());
            const m = this.$root.utils.generic.padZero(now.getMonth() + 1);
            const y = now.getFullYear()

            this.filters.date_start = y + '-' + m + '-' + d;
            this.filters.date_end = y + '-' + m + '-' + d;
            this.filters.description = 'di oggi';
            this.list();
        },
        setYesterday() {
            const today = new Date()
            const yesterday = new Date(today)
            yesterday.setDate(yesterday.getDate() - 1)

            const d = this.$root.utils.generic.padZero(yesterday.getDate());
            const m = this.$root.utils.generic.padZero(yesterday.getMonth() + 1);
            const y = yesterday.getFullYear()

            this.filters.date_start = y + '-' + m + '-' + d;
            this.filters.date_end = y + '-' + m + '-' + d;
            this.filters.description = 'di ieri';
            this.list();
        },
        setCurrentWeek() {
            let now = new Date();
            let cw = new Date();

            var day = cw.getDay()                   // current week
            const diff = cw.getDate() - day + (day == 0 ? -6:1);     // adjust when day is monday
            cw =  new Date(cw.setDate(diff));

            const d1 = this.$root.utils.generic.padZero(cw.getDate());
            const m1 = this.$root.utils.generic.padZero(cw.getMonth() + 1);
            const y1 = cw.getFullYear()

            const d = this.$root.utils.generic.padZero(now.getDate());
            const m = this.$root.utils.generic.padZero(now.getMonth() + 1);
            const y = now.getFullYear()

            this.filters.date_start = y1 + '-' + m1+ '-' + d1;
            this.filters.date_end = y + '-' + m + '-' + d;
            this.filters.description = 'della settimana corrente';
            this.list();
        },
        setLastWeek() {
            let lw = new Date();
            lw.setDate(lw.getDate() - 7)            // last week
            var day = lw.getDay()
            const diff = lw.getDate() - day + (day == 0 ? -6:1);        // adjust when day is monday
            lw =  new Date(lw.setDate(diff));

            const d1 = this.$root.utils.generic.padZero(lw.getDate());
            const m1 = this.$root.utils.generic.padZero(lw.getMonth() + 1);
            const y1 = lw.getFullYear()

            let cw = new Date();

            var day2 = cw.getDay()                   // current week
            const diff2 = cw.getDate() - day2 + (day2 == 0 ? -6:1);     // adjust when day is monday
            cw =  new Date(cw.setDate(diff2 - 1));                      //n points to previous sunday

            const d = this.$root.utils.generic.padZero(cw.getDate());
            const m = this.$root.utils.generic.padZero(cw.getMonth() + 1);
            const y = cw.getFullYear()

            this.filters.date_start = y1 + '-' + m1+ '-' + d1;
            this.filters.date_end = y + '-' + m + '-' + d;
            this.filters.description = 'della settimana scorsa';
            this.list();
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
        setLastMonth() {
            let now = new Date()
            now.setDate(0)                            // last day of the previous month

            const d = this.$root.utils.generic.padZero(now.getDate());
            const m = this.$root.utils.generic.padZero(now.getMonth() + 1);
            const y = now.getFullYear()

            this.filters.date_start = y + '-' + m + '-01';
            this.filters.date_end = y + '-' + m + '-' + d;
            this.filters.description = 'del mese scorso';
            this.list();
        },
        setCurrentYear() {
            // sets period to current year
            const now = new Date();
            const d = this.$root.utils.generic.padZero(now.getDate());
            const m = this.$root.utils.generic.padZero(now.getMonth() + 1);
            const y = now.getFullYear()

            this.filters.date_start = y + '-01-01';
            this.filters.date_end = y + '-' + m + '-' + d;
            this.filters.description = 'da inizio anno';
            this.list();
        },
        setPeriod() {
            this.filters.description = 'nel periodo selezionato';
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
        },
        // #endregion utils
    }
    // #region Methods
}
</script>
