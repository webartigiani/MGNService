<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <h3>{{ filtersTitle }} {{ filters.description }}</h3>

            <div class="card">
                <div class="card-header">
                    <div class="card-title col-9 filters">
                        <label for="per_page">Visualizza</label>
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
                        <button type="button"
                            class="btn btn-sm btn-primary btn-green"
                            title="Esporta Presenze in formato Excel/CSV"
                            @click="exportData()">
                            <i class="fa fa-file-excel"></i>
                            Esporta CSV
                        </button>
                        <button type="button"
                            class="btn btn-sm btn-primary btn-green"
                            title="Esporta Presenze in formato XML per Zucchetti"
                            @click="exportDataXML()">
                            <i class="fa fa-file-alt"></i>
                            Esporta XML
                        </button>
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
                                    @change="setPeriod(); list()"
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

                                <button type="button"
                                    class="btn btn-sm btn-primary"
                                    title="Resetta Filtri"
                                    @click="setCurrentYear()">
                                    <i class="far fa-calendar"></i>
                                    Anno Corrente
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-primary"
                                    title="Resetta Filtri"
                                    @click="setLastMonth()">
                                    <i class="fas fa-history"></i>
                                    Mese Scorso
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-primary btn-green"
                                    title="Resetta Filtri"
                                    @click="setCurrentMonth()">
                                    <i class="far fa-calendar-check"></i>
                                    Mese Corrente
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-primary btn-green"
                                    title="Resetta Filtri"
                                    @click="setYesterday()">
                                    <i class="fas fa-history"></i>
                                    Ieri
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-primary btn-green"
                                    title="Resetta Filtri"
                                    @click="setToday()">
                                    <i class="far fa-clock"></i>
                                    Oggi
                                </button>
                            </div>
                            <div class="col-2 text-right">
                                <input type="checkbox" id="notatwork"
                                    v-model="filters.notatwork"
                                    @change="list()"
                                title="Spunta per visualizzare solo le assenze">
                                <label for="notatwork">Visualizza Assenze</label>
                            </div>
                        </div>
                    </div>
                </div>
                </transition>

              <!-- body -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Data</th>
                      <th>Nome</th>
                      <th>Cognome</th>
                      <th>Presenza</th>
                      <th>Entrata</th>
                      <th>Uscita</th>
                      <th>Ore Lavorate</th>
                      <th>Azioni</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="item in items.data" :key="item.id">
                      <td>{{ (item.chk >= 0) ? item.id: '' }}</td>
                      <td>{{ item.day_date }}</td>
                      <td>{{ item.nome }}</td>
                      <td>{{ item.cognome }}</td>
                      <td>
                          <span class="badge"
                          :class="presenzaToClass(item.chk)"
                          >{{ presenzaString(item.chk) }}</span>
                      </td>
                      <td>{{ attendanceTime(item.day_date, item.entrance_date) }}</td>
                      <td>{{ attendanceTime(item.day_date, item.exit_date) }}</td>
                        <td>{{ (item.chk >= 0) ? item.duration_h: '' }}</td>
                      <td>
                        <a href="#"
                            class="action"
                            title="Modifica"
                            @click="editModal(item)"
                            v-if="item.chk >= 0"
                            >
                            <i class="fa fa-pen blue"></i>
                        </a>
                        <a href="#"
                            class="action"
                            title="Elimina"
                            @click="deleteItem(item.id)"
                            v-if="item.chk >= 0"
                            >
                            <i class="fa fa-trash blue"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <!-- see pagination componenet https://www.npmjs.com/package/laravel-vue-pagination -->
                  <pagination
                    :data="items" @pagination-change-page="getResults"
                    :limit=10
                  ></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

    <!-- Modal/Form -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Nuovo Dipentente</h5>
                    <h5 class="modal-title" v-show="editmode">Modifca Dipendente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateItem() : createItem()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nome</label>
                            <input v-model="form.nome" type="text" name="nome"
                                class="form-control upper" :class="{ 'is-invalid': form.errors.has('nome') }"
                                :maxlength="64" :readonly="editmode"
                                >
                            <has-error :form="form" field="nome"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Cognome</label>
                            <input v-model="form.cognome" type="text" name="cognome"
                                class="form-control upper" :class="{ 'is-invalid': form.errors.has('cognome') }"
                                :maxlength="64" :readonly="editmode"
                                >
                            <has-error :form="form" field="cognome"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Codice Fiscale</label>
                            <input v-model="form.codice_fiscale" type="text" name="codice_fiscale"
                                class="form-control upper" :class="{ 'is-invalid': form.errors.has('codice_fiscale') }"
                                :maxlength="16" :readonly="editmode"
                                >
                            <has-error :form="form" field="codice_fiscale"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Matricola</label>
                            <input v-model="form.matricola" type="text" name="matricola"
                                class="form-control upper" :class="{ 'is-invalid': form.errors.has('matricola') }"
                                :maxlength="16" :readonly="editmode"
                                >
                            <has-error :form="form" field="matricola"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Modalità Timbrata</label>
                            <select name="modo_timbratura"
                                v-model="form.modo_timbratura"
                                class="form-control"
                                >
                                <option value="0">Tutte</option>
                                <option value="1">Veicolo Aziendale</option>
                                <option value="2">Veicolo Proprio</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <!--
                                data_assunzione
                                between date-7 => date+7
                            -->
                            <label>Data Assunzione</label>
                            <input v-model="form.data_assunzione" type="date" name="data_assunzione"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('data_assunzione') }"
                                :readonly="editmode"
                                :min="$root.utils.datetime.formatDateISO($root.utils.datetime.dateAddDays(new Date(), -7))"
                                :max="$root.utils.datetime.formatDateISO($root.utils.datetime.dateAddDays(new Date(), 7))"
                                >
                            <has-error :form="form" field="data_assunzione"></has-error>
                        </div>
                        <div class="form-group"
                            v-if="editmode"
                            >
                            <label>Data Cessazione</label>
                            <input v-model="form.data_cessazione" type="date" name="data_cessazione"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('data_cessazione') }"
                                :readonly="(form.data_cessazione != null)"
                                :min="$root.utils.datetime.formatDateISO(form.data_assunzione)"
                                :max="$root.utils.datetime.formatDateISO($root.utils.datetime.dateAddDays(new Date(), 7))"
                                >
                            <has-error :form="form" field="data_cessazione"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Salva</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Salva</button>
                    </div>
                  </form>
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
</style>

<script>
import VueTagsInput from '@johmun/vue-tags-input';
import Vue from 'vue'

export default {
    components: {
        VueTagsInput,
    },

    // #region Properties
    data () {
        return {
            editmode: false,
            items : {},
            form: new Form({
                id : '',
                nome: '',
                cognome: '',
                codice_fiscale: '',
                matricola: '',
                modo_timbratura: 0,
                data_assunzione: '',
                data_cessazione: ''
            }),
            // filters
            filters: {
                show: false,
                date_start: null,
                date_end: null,
                description: 'di oggi',
                notatwork: false,
                per_page: 10
            },
        }
    },
    filters: {
    },
    computed: {
        filtersTitle() {
            return this.filters.notatwork ? 'Assenze': 'Presenze'
        }
    },
    // #endregion Properties

    methods: {
        getResults(page = 1) {
            this.$Progress.start();
            let params = this.filters                           // appends filters and search
            params.query = this.$root.$route.query.search
            axios.get('api/attendance?page=' + page, {
                params: params
            }).then(({ data }) => (this.items = data.data));
            this.$Progress.finish();
        },

        // #region Modals
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        editModal(item) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(item);
        },
        // #endregion Modals

        // #region CRUD Functions
        list() {
            this.$Progress.start();
            this.checkFilters()
            let params = this.filters                           // appends filters and search
            params.query = this.$root.$route.query.search
            axios.get('api/attendance', {
                params: params
            }).then(({ data }) => (this.items = data.data, console.log(data.data), this.$Progress.finish()));
        },
        createItem(){
            this.$Progress.start();

            this.form.post('api/attendance')
                .then((data)=>{
                    if(data.data.success){
                        $('#addNew').modal('hide');

                        Toast.fire({
                            icon: 'success',
                            title: data.data.message
                        });
                        this.$Progress.finish();
                        this.list();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Si è verificato un errore! Prego, riprova'
                        });
                        this.$Progress.failed();
                    }
                    })
                .catch(()=>{
                    Toast.fire({
                        icon: 'error',
                        title: 'Si è verificato un errore! Prego, riprova'
                    });
                })
        },
        updateItem(){
            this.$Progress.start();
            this.form.put('api/attendance/'+this.form.id)
            .then((response) => {
                // success
                $('#addNew').modal('hide');
                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                });
                this.$Progress.finish();
                //  Fire.$emit('AfterCreate');
                this.list();
            })
            .catch(() => {
                this.$Progress.fail();
            });

        },
        deleteItem(id){
            Swal.fire({
                title: 'Conferma',
                icon:'question',
                html: "Confermi la cancellazione del dipendente?",
                showCancelButton: true,
                confirmButtonText: 'Si, procedi',
                cancelButtonText: 'Annulla'
                }).then((result) => {
                    // Send request to the server
                    if (result.value) {
                        this.form.delete('api/attendance/'+id).then(()=>{
                            Swal.fire(
                                'Eliminato!',
                                'Dipendente correttamente eliminato.',
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

        // #region Export Functions
        exportData: async function() {
            // see: https://edionme.com/blogs/exportdownload-data-to-csv-with-laravel-and-vue
            this.$Progress.start();
            const response = await axios({
                method: 'get',
                url: 'api/attendances/export',
                params: this.filters
            })

            // search query
            let query = this.$root.$route.query.search.trim().toLowerCase();

            // choose filename
            let fileName = this.filters.notatwork ? 'assenze': 'presenze'
            fileName += '_' + this.filters.date_start + '_' + this.filters.date_end
            fileName += (query != '') ? '_' + query : ''

            // download
            this.$root.download.saveFile(response, fileName + '.csv', 'text/csv')   // exports CSV
            this.$Progress.finish();
        },
        exportDataXML: async function() {
            // see: https://edionme.com/blogs/exportdownload-data-to-csv-with-laravel-and-vue
            this.$Progress.start();
            const response = await axios({
                method: 'get',
                url: 'api/attendances/export-xml',
                params: this.filters
            })

            // choose filename
            const fileName = 'TRRIPW_' + this.filters.date_start + '_' + this.filters.date_end
            this.$root.download.saveFile(response, fileName + '.xml', 'text/xml')   // exports XML
            this.$Progress.finish();
        },
        // #endregion Export Functions

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
        setPeriod() {
            this.filters.description = 'nel periodo selezionato';
        },
        // #endregion Filters Functions

        // #region Utils
        presenzaString(v) {
            // returns presenza description
            switch (v) {
                case -1: return 'assente';
                case 0: return 'incompleta';
                case 1: return 'presente';
            }
        },
        presenzaToClass(v) {
            // returns presenza class
            switch (v) {
                case -1: return 'badge-danger';
                case 0: return 'badge-warning';
                case 1: return 'badge-success';
            }
        },
        attendanceTime(dayDate, t) {
            if (t == null) return ''
            if (dayDate == '') return ''
            //t = this.$root.utils.datetime.formatDateTime(t)
            console.log(t)
            return t.replace(dayDate, '')
        }
        // #endregion utils
    },

    // #region Component Life Cycle
    beforeCreate() {
    },
    created() {
        this.$Progress.start();

        // set today
        const now = new Date();
        const d = this.$root.utils.generic.padZero(now.getDate());
        const m = this.$root.utils.generic.padZero(now.getMonth() + 1);
        const y = now.getFullYear()

        this.filters.date_start = y + '-' + m + '-' + d;
        this.filters.date_end = y + '-' + m + '-' + d;

        this.list();          // invoked by setCurrentMonth
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
