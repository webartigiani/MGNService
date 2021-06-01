<template>
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <!-- timbrate recenti -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Timbrate Recenti</h3>
                        </div>
                        <div class="card-body p-0">
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
                                            <td v-if="item.chk < 1">{{ attendanceTime(item.day_date, item.entrance_date) }}</td>
                                            <td v-if="item.chk == 1">{{ attendanceTime(item.day_date, item.exit_date) }}</td>
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
                        <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Presenti</span>
                            <span class="info-box-number">13/25</span>
                        </div>
                    </div>

                    <!-- dipendenti assenti -->
                    <div class="info-box mb-3 bg-warning">
                        <span class="info-box-icon"><i class="far fa-tired"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Chi manca?</span>
                            <span class="info-box-number">12</span>
                        </div>
                    </div>

                    <!-- veicoli in uso -->
                    <div class="info-box mb-3 bg-info">
                        <span class="info-box-icon"><i class="fas fa-car"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Veicoli in uso</span>
                            <span class="info-box-number">2/2</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    // #region Properties
    data () {
        return {
            presenze : {},
            filters: {
                show: false,
                date_start: null,
                date_end: null,
                notatwork: false,
                per_page: 10
            },
        }
    },
    filters: {
    },
    computed: {
    },
    // #endregion Properties

    // #region Methods
    methods: {
        getResultsPresenze(page = 1) {
            this.$Progress.start();
            axios.get('api/attendance?page=' + page, {
                params: {"context": "dashboard"}
            }).then(({ data }) => (this.presenze = data.data));
            this.$Progress.finish();
        },
        listPresenze() {
            this.$Progress.start();
            axios.get('api/attendance', {
                params: {"context": "dashboard"}
            }).then(({ data }) => (this.presenze = data.data, console.log('listPresenze', data.data), this.$Progress.finish()));
        },

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
    // #region Methods

    // #region Component Life Cycle
    beforeCreate() {
    },
    created() {
        this.$Progress.start()
        this.listPresenze()
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
