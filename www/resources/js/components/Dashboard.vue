<template>
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <!-- timbrate recenti -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ loadingTable ? `caricamento...` : `Entrate / Uscite Recenti` }}</h3>
                        </div>
                        <div class="card-body p-0"
                            >
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Dipendente</th>
                                            <th>Timbrata</th>
                                            <th>Data</th>
                                            <th>Ora</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in presenze.data" :key="item.id">
                                            <td style="width:20px;">
                                                <i class="fa fa-dot-circle"
                                                    :title="(item.worker_status==1 ? 'attualmente presente' : 'attualmente assente')"
                                                    :class="(item.worker_status==1 ? 'green' : 'orange')"></i>
                                            </td>
                                            <td>{{ item.nome }} {{ item.cognome }}</td>
                                            <td>
                                                <span class="badge"
                                                :class="timbrataToClass(item.chk)"
                                                >{{ timbrataToString(item.chk) }}</span>
                                            </td>
                                            <td>{{ item.day_date }}</td>
                                            <td v-if="item.chk < 1">
                                                <!-- entrance date/time 1 or 2 -->
                                                {{ item.entrance_date_2 === null ? attendanceTime(item.day_date, item.entrance_date) : attendanceTime(item.day_date, item.entrance_date2) }}
                                            </td>
                                            <td v-if="item.chk == 1">
                                                <!-- exit date/time 1 or 2 -->
                                                {{ item.exit_date_2 === null ? attendanceTime(item.day_date, item.exit_date) : attendanceTime(item.day_date, item.exit_date_2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="card-footer">
                                    <!-- see pagination componenet https://www.npmjs.com/package/laravel-vue-pagination -->
                                    <pagination
                                        :data="presenze" @pagination-change-page="getResultsPresenze"
                                        :limit=10
                                    ></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- dipendenti presenti -->
                    <div class="info-box mb-3 bg-success">
                        <span class="info-box-icon top" v-show="!loadingCounters"><i class="fas fa-tag"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ loadingCounters ?  `caricamento...`: `Presenti` }}</span>
                            <span class="info-box-number">{{ loadingCounters ?  `...`: workersAtWork + `/` + totalWorkers }}</span>
                            <br>
                            <a href="#" class="mini-link"
                                @click.prevent="showWorkersAtWork()"
                                v-show="(!loadingCounters) && (workersAtWork>0)"
                            >visualizza</a>
                        </div>
                    </div>
                    <!-- dipendenti assenti -->
                    <div class="info-box mb-3 bg-warning">
                        <span class="info-box-icon top" v-show="!loadingCounters"><i class="far fa-tired"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ loadingCounters ?  `caricamento...`: `Assenti` }}</span>
                            <span class="info-box-number">{{ loadingCounters ?  `...`: workersNotAtWork }}</span>
                            <br>
                            <a href="#" class="mini-link"
                                @click.prevent="showWorkersNotAtWork()"
                                v-show="(!loadingCounters) && (workersNotAtWork > 0)"
                            >visualizza</a>
                        </div>
                    </div>
                    <!-- veicoli in uso -->
                    <div class="info-box mb-3 bg-info">
                        <span class="info-box-icon top" v-show="!loadingCounters"><i class="fas fa-car"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ loadingCounters ?  `caricamento...`: `Veicoli in uso` }}</span>
                            <span class="info-box-number">{{ loadingCounters ?  `...`: veichlesInUse + `/` + totaleVeichles}}</span>
                            <br>
                            <a href="#" class="mini-link"
                                @click.prevent="showViechlesInUse()"
                                v-show="(!loadingCounters) && (veichlesInUse>0)"
                            >visualizza</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Modal  -->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ modal.title }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <ul>
                            <li v-for="item in modal.list" :key="item.id">{{ item.item }}</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.info-box-icon.top {
    display: block;
}

/* links */
a.mini-link {
    color:#fff;
    text-transform: lowercase;
}
a.mini-link:hover {
    text-decoration: none;
}
div.bg-warning a.mini-link {
    color: #1f2d3d!important;
}
</style>

<script>
export default {
    // #region Properties
    props: [
        'user_type'          // user property is the Laravel User object passed throught <router-view user_type="{{ Auth::user()->type }}"></router-view> in master.blade
    ],
    data () {
        return {
            loadingTable: true,
            loadingCounters: true,
            presenze : {},
            totalWorkers: 0,
            workersAtWork: 0,
            workersNotAtWork: 0,
            veichlesInUse: 0,
            totaleVeichles: 0,
            filters: {
                show: false,
                date_start: null,
                date_end: null,
                notatwork: false,
                per_page: 10
            },
            modal: {
                title: '',
                list: [],
            }
        }
    },
    computed: {
    },
    // #endregion Properties

    // #region Methods
    methods: {
        getResultsPresenze(page = 1) {
            this.$Progress.start()
            this.loadingTable = true
            axios.get('api/attendance?page=' + page, {
                params: {"context": "dashboard", "per_page": 10}
            }).then(({ data }) => {
                this.presenze = data.data
                this.$Progress.finish()
                this.loadingTable = false
            });
        },
        listLastTimbrate() {
            /*
            Lists timbrate, 10-per-page
             */
            this.$Progress.start()
            this.loadingCounters = true
            axios.get('api/attendance', {
                params: {"context": "dashboard", "per_page": 10}
            }).then(({ data }) => {
                this.presenze = data.data
                this.$Progress.finish()
                this.loadingTable = false
            });
        },
        /**
         * Gets workers and veichels counters
         */
        getCounters() {
            this.$Progress.start();
            this.loadingCounters = true
            axios.get('api/workers/counters', {
                params: {}
            }).then(({ data }) => {
                this.workersAtWork = data.data[0].atwork
                this.workersNotAtWork = data.data[0].notatwork
                this.totalWorkers = data.data[0].total

                axios.get('api/veichles/counters', {
                    params: {}
                }).then(({ data }) => {
                    this.veichlesInUse = data.data[0].inuse
                    this.totaleVeichles = data.data[0].total
                    this.loadingCounters = false
                    this.$Progress.finish();
                });
            });
        },

        // #region Modals Functions
        showWorkersAtWork() {
            this.$Progress.start();
            axios.get('api/workers/atwork', {
                params: {}
            }).then(({ data }) => {
                this.modal.title = 'Dipendenti Presenti'
                this.modal.list = data.data
                $('#modal').modal('show');
                this.$Progress.finish();
            });
        },
        showWorkersNotAtWork() {
            this.$Progress.start();
            axios.get('api/workers/notatwork', {
                params: {}
            }).then(({ data }) => {
                this.modal.title = 'Dipendenti Assenti'
                this.modal.list = data.data
                $('#modal').modal('show');
                this.$Progress.finish();
            });
        },
        showViechlesInUse() {
            this.$Progress.start();
            axios.get('api/veichles/inuse', {
                params: {}
            }).then(({ data }) => {
                this.modal.title = 'Veicoli in Uso'
                this.modal.list = data.data
                $('#modal').modal('show');
                this.$Progress.finish();
            });
        },
        // #endregion Modals Functions

        // #region Utils
        timbrataToString(v) {
            // returns timbrata description
            switch (v) {
                case 0: return 'entrata';
                case 1: return 'uscita';
            }
        },
        timbrataToClass(v) {
            // returns timbrata class
            switch (v) {
                case 0: return 'badge-success';
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
    // #endregion Methods

    // #region Component Life Cycle
    beforeCreate() {
    },
    created() {
        this.$Progress.start()
        this.listLastTimbrate()
        this.getCounters()
        this.$Progress.finish()
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
