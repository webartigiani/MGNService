<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <h3>{{ filtersTitle }} {{ filters.description }}</h3>

            <div class="card">
                <div class="card-header">
                    <div class="card-title col-9 filters">
                        <select name="per_page" id="per_page"
                            class="form-control"
                            v-model="filters.per_page"
                            @change="list()"
                            >
                            <option value=10>10 per pagina</option>
                            <option value=25>25 per pagina</option>
                            <option value=50>50 per pagina</option>
                        </select>
                    </div>
                    <!-- tools -->
                    <div class="card-tools col-3 text-right">
                        <button type="button"
                            class="btn btn-sm btn-primary btn-green"
                            title="Esporta le note del periodo selezionato"
                            :disabled="items.data.length == 0"
                            @click="exportNotes()">
                            <i class="fa fa-file-pdf"></i>
                            Esporta Note
                        </button>
                        <button type="button"
                            class="btn btn-sm btn-primary btn-green"
                            title="Esporta Presenze in formato Excel/CSV"
                            :disabled="items.data.length == 0"
                            @click="exportData()"
                            >
                            <i class="fa fa-file-excel"></i>
                            Esporta CSV
                        </button>
                        <button type="button"
                            class="btn btn-sm btn-primary btn-green"
                            title="Esporta Presenze in formato XML per Zucchetti"
                            :disabled="items.data.length == 0"
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
                                <input type="checkbox" id="notatwork"
                                    v-model="filters.notatwork"
                                    @change="list()"
                                title="Spunta per visualizzare solo le assenze">
                                <label for="notatwork">trova Assenze</label>
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
                      <th>Data</th>
                      <th>Nome</th>
                      <th>Cognome</th>
                      <th><!-- Presenza --></th>
                      <th>Entrata</th>
                      <th>Uscita</th>
                      <th>Rientro</th>
                      <th>Uscita</th>
                      <th>Ore Presenza</th>
                      <th>Ore Lavorate</th>
                      <th>Ore Assenza</th>
                      <th></th>
                      <th>Ore Totali</th>
                      <th>Azioni</th>
                    </tr>
                  </thead>
                  <tbody
                    v-show="items.data.length > 0"
                    >
                     <tr v-for="item in items.data" :key="item.id">
                        <td style="width:20px;">
                            <i class="fa fa-dot-circle"
                                :title="(item.worker_status==1 ? 'attualmente presente' : 'attualmente assente')"
                                :class="(item.worker_status==1 ? 'green' : 'orange')"></i>
                        </td>
                        <!-- <td>{{ item.id }}</td> -->
                        <td>{{ item.day_date }}</td>
                        <td>{{ item.nome }}</td>
                        <td>{{ item.cognome }}</td>
                        <td>
                            <span class="badge"
                            :class="presenzaToClass(item)"
                            >{{ presenzaString(item) }}</span>
                        </td>
                        <td>{{ attendanceTime(item.day_date, item.entrance_date) }}</td>
                        <td>{{ attendanceTime(item.day_date, item.exit_date) }}</td>
                        <td>{{ attendanceTime(item.day_date, item.entrance_date_2) }}</td>
                        <td>{{ attendanceTime(item.day_date, item.exit_date_2) }}</td>
                        <td>{{ $root.utils.generic.padZero(item.duration_h_int) + ':' + $root.utils.generic.padZero(item.residual_m) }}</td>
                        <td>{{ $root.utils.generic.padZero(item.duration_h_int) + ':' + $root.utils.generic.padZero(item.residual_m_int) }}</td>
                        <td>{{ $root.utils.generic.padZero(item.abscence_h_int) + ':' + $root.utils.generic.padZero(item.abscence_minutes_int) }}</td>
                        <td>
                            <span class="badge"
                            :class="assenzaToClass(item)"
                            v-if="item.abscence_justification != '' && item.abscence_justification != '_R'"
                            >{{ item.abscence_justification_desc }}</span>
                        </td>
                        <td>{{ $root.utils.generic.padZero(item.total_h_int) + ':' + $root.utils.generic.padZero(item.total_minutes_int) }}</td>
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
                                @click="deleteItem(item)"
                                v-if="item.chk >= 0"
                                >
                                <i class="fa fa-trash blue"></i>
                            </a>
                            <a href="#"
                                class="action"
                                title="Gestisci Assenze"
                                @click="addEditAbscence(item)"
                                >
                                <i class="fa fa-balance-scale"
                                    :class="(item.abscence_justification != '') ? `blue` : `gray`"
                                ></i>
                            </a>
                            <a href="#"
                                class="action"
                                :title="`Gestisci Note`"
                                @click="addEditNotes(item)"
                                >
                                <i class=""
                                    :class="(item.notes != '') ? `blue fas fa-clipboard-check` : `gray far fa-clipboard`"
                                ></i>
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

    <!-- Editor Modal/Form -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">NON IMPLEMENTATA</h5>
                    <h5 class="modal-title" v-show="editmode">Modifca Timbrata</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateItem() : createItem()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Dipendente</label><br>
                                {{ form.nome }} {{ form.cognome }}
                            </div>
                            <div class="col-md-6">
                                <label>Data</label><br>
                                {{ form.day_date }}
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="entrance_time">Orario Entrata</label>
                                    <input type="time" name="entrance_time"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('entrance_time') }"
                                        step="1"
                                        v-model="form.entrance_time"
                                        >
                                    <has-error :form="form" field="entrance_time"></has-error>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="entrance_time">{{ form.pausa_orario ? 'Orario Pausa' : 'Orario Uscita'}}</label>
                                    <input type="time" name="exit_date"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('exit_date') }"
                                        step="1"
                                        v-model="form.exit_time"
                                        >
                                    <has-error :form="form" field="exit_date"></has-error>
                                </div>
                            </div>
                        </div>

                        <!-- orario seconda timbrata se il dipendente è abilitato -->
                        <div class="row"
                            v-if="form.pausa_orario"
                        >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="entrance_time_2">Orario Rientro</label>
                                    <input type="time" name="entrance_time_2"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('entrance_time_2') }"
                                        step="1"
                                        v-model="form.entrance_time_2"
                                        >
                                    <has-error :form="form" field="entrance_time_2"></has-error>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exit_time_2">Orario Uscita</label>
                                    <input type="time" name="exit_time_2"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('exit_date_2') }"
                                        step="1"
                                        v-model="form.exit_time_2"
                                        >
                                    <has-error :form="form" field="exit_date_2"></has-error>
                                </div>
                            </div>
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

    <!-- Abscence Editor -->
        <div class="modal fade" id="modalAbscences" tabindex="-1" role="dialog" aria-labelledby="modalAbscences" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Giustifica Assenza</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="upsertAbscence()">
                    <div class="modal-body">
                        <div class="form-group">
                            <b>
                            {{ form.nome }} {{ form.cognome }}<br>
                            {{ form.day_date }}
                            </b>
                        </div>

                        <div class="form-group">
                            <label for="abscence_time">Ore di Assenza</label>
                            <input type="time" name="abscence_time"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('abscence_time') }"
                                step="900"
                                v-model="form.abscence_time"
                                required
                                >
                            <has-error :form="form" field="abscence_time"></has-error>
                        </div>
                        <div class="form-group">
                            <label for="abscence_justification">Motivazione</label>
                            <select name="abscence_justification" id="abscence_justification"
                                class="form-control"
                                required
                                v-model="form.abscence_justification"
                                >
                                <option value="">-seleziona-</option>
                                <option :value="item.code"
                                    v-for="item in giustificativi" :key="item.code"
                                >{{ item.description }}</option>
                            </select>
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

    <!-- Notes Editor -->
        <div class="modal fade" id="modalNotes" tabindex="-1" role="dialog" aria-labelledby="modalNotes" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gestisci Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="updsertNotes()">
                    <div class="modal-body">
                        <div class="form-group">
                            <b>
                            {{ form.nome }} {{ form.cognome }}<br>
                            {{ form.day_date }}
                            </b>
                        </div>
                        <div class="form-group">
                            <label for="notes">Note</label>
                            <textarea name="notes" id="notes"
                                class="form-control notes"
                                maxlength="512"
                                v-model="form.notes"
                                >
                            </textarea>
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
.btn-green, .btn-green:focus, .btn-green:active {
    /* overwrite some styles */
    background-color: #38c172!important;
    border-color: #38c172!important;
}
textarea.notes {
  resize: none;
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
            giustificativi: [],
            form: new Form({
                id : '',
                nome: '',
                cognome: '',
                codice_fiscale: '',
                pausa_orario: false,
                matricola: '',
                entrance_date: '',
                entrance_time: '',
                entrance_ip: '',
                exit_date: '',
                exit_time: '',
                exit_ip: '',
                entrance_time_2: '',
                entrance_ip_2: '',
                exit_time_2: '',
                exit_ip_2: '',
                ref_date: '',
                worker_id: '',
                worker_status: '',
                day_date: '',
                abscence_minutes: '',
                abscence_justification: '',
                abscence_time: '00:00',
                notes: ''
            }),
            // filters
            filters: {
                show: false,
                date_start: null,
                date_end: null,
                description: 'di oggi',
                notatwork: false,
                per_page: 50
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

    // #region Methods
    methods: {
        getResults(page = 1) {
            this.$Progress.start();
            let params = this.filters                           // appends filters and search
            params.query = this.$root.$route.query.search
            axios.get('api/attendance?page=' + page, {
                params: params
            }).then(({ data }) => (this.items = data.data, this.$Progress.finish()));
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

            // sets entrance/exit time
            this.form.entrance_time = this.attendanceTime(item.day_date, item.entrance_date)
            this.form.exit_time = this.attendanceTime(item.day_date, item.exit_date)
            this.form.entrance_time_2 = this.attendanceTime(item.day_date, item.entrance_date_2)
            this.form.exit_time_2 = this.attendanceTime(item.day_date, item.exit_date_2)
            this.form.pausa_orario = (item.pausa_orario === 1)
        },
        addEditAbscence(item) {
            // Adds/Edits Abscence
            this.editmode = false;
            this.form.reset();
            $('#modalAbscences').modal('show');
            this.form.fill(item);

            // calculates abscence_time
            this.form.abscence_time = this.$root.utils.generic.padZero(item.abscence_h_int) + ':' + this.$root.utils.generic.padZero(item.abscence_minutes_int)
        },
        addEditNotes(item) {
            // Adds/Edits Notes
            this.editmode = false;
            this.form.reset();
            $('#modalNotes').modal('show');
            this.form.fill(item);
        },
        // #endregion Modals

        // #region CRUD Functions
        list() {
            this.$Progress.start();
            this.checkFilters()
            let params = this.filters                           // appends filters and search
            params.query = this.$root.$route.query.search
            axios.get('api/attendance?page=1', {
                params: params
            }).then(({ data }) => (this.items = data.data, this.$Progress.finish()));
        },
        createItem(){
            /*
            NOTE: attendance store/create functions is disabled

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
            */
        },
        updateItem(){
            // validates data
            if (!this.validateForm()) return


            console.log(this.form)

            this.$Progress.start();

            this.form.put('api/attendance/' + this.form.id)
            .then((response) => {
                // success
                $('#addNew').modal('hide');
                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                });
                this.$Progress.finish();
                this.list();
            })
            .catch(() => {
                this.$Progress.fail();
            });

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
        validateForm() {

            // validates required data
            if (this.form.pausa_orario) {
                // dipendente con pausa
                if (this.form.entrance_time === '' || this.form.exit_time_2 === '') {
                    Toast.fire({
                        icon: 'error',
                        title: '"Orario Entrata" e "Orario Uscita" sono entrambi richiesti'
                    });
                    return false
                }

                // se ha inserito pausa, richiede entrambi i dati
                if (this.form.entrance_time_2 !== '' || this.form.exit_time !== '') {
                    if (this.form.entrance_time_2 === '' || this.form.exit_time === '') {
                        Toast.fire({
                            icon: 'error',
                            title: 'In caso di pausa, "Orario Pausa" e "Orario Rientro" devono essere entrambi specificati.'
                        })
                        return false
                    }
                }
            } else {
                // dipendente senza pausa
                if (this.form.entrance_time === '' || this.form.exit_time === '') {
                    Toast.fire({
                        icon: 'error',
                        title: '"Orario Entrata" e "Orario Uscita" sono entrambi richiesti'
                    });
                    return false
                }
            }

            // checks times:
            // inserisce gli orari in un array, ne crea una copia, e fa il sorting
            // quindi confronta copia con array originale.
            // se vi sono differenze, l'utente ha inserito orari d'entrata successivi alle uscite
            const arr1 = []
            arr1.push(this.form.entrance_time)
            if (this.form.exit_time !== '') arr1.push(this.form.exit_time)
            if (this.form.entrance_time_2 !== '') arr1.push(this.form.entrance_time_2)
            if (this.form.exit_time_2 !== '') arr1.push(this.form.exit_time_2)

            const arr2 = JSON.parse(JSON.stringify(arr1)).sort()    // sorting degli orari inseriti

            if (arr1.join() !== arr2.join()) {
                Toast.fire({
                    icon: 'error',
                    title: 'Gli orari di uscita devono essere successivi a quelli di entrata'
                });
                return false
            }

            // checks duplicates:
            let arr3 = [...new Set(arr1)];
            if (arr3.length < arr1.length) {
                Toast.fire({
                    icon: 'error',
                    title: 'Gli orari di uscita devono essere successivi a quelli di entrata'
                });
                return false
            }

            // normalizes form
            if (arr2.length === 2) {
                this.form.entrance_time = arr2[0]
                this.form.exit_time = arr2[1]
                this.form.entrance_time_2 = ''
                this.form.exit_time_2 = ''
            }
            if (arr2.length === 2) {
                this.form.entrance_time = arr2[0]
                this.form.exit_time = arr2[1]
                this.form.entrance_time_2 = arr2[2]
                this.form.exit_time_2 = arr2[3]
            }
            return true
        },

        upsertAbscence() {
            // inserts/updates abscence
            this.$Progress.start();

            this.form.post('api/abscence')
                .then((response)=>{
                    console.log(response.data)
                    if(response.data.success) {
                        $('#modalAbscences').modal('hide');
                        this.$Progress.finish();
                        this.list();
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });
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
        updsertNotes() {
            // inserts/updates abscence
            this.$Progress.start();

            this.form.post('api/note')
                .then((response)=>{
                    console.log(response.data)
                    if(response.data.success) {
                        $('#modalNotes').modal('hide');
                        this.$Progress.finish();
                        this.list();
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });
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
        // #endregion CRUD Functions

        // #region Other Data Functions
        listGiustificativi() {
            axios.get('api/attendances/giustificativi', {}).then(({ data }) => {
                this.giustificativi = data
            });
        },
        // #endregion other Data Functions

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
            let query = (this.$root.$route.query.search != undefined) ? this.$root.$route.query.search.trim().toLowerCase() : '';

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
        exportNotes: async function() {
            // see: https://edionme.com/blogs/exportdownload-data-to-csv-with-laravel-and-vue
            this.$Progress.start();
            const response = await axios({
                method: 'get',
                url: 'api/attendances/export-notes',
                params: this.filters
            })

            // search query
            let query = (this.$root.$route.query.search != undefined) ? this.$root.$route.query.search.trim().toLowerCase() : '';

            // choose filename
            let fileName = 'note'
            fileName += '_' + this.filters.date_start + '_' + this.filters.date_end
            fileName += (query != '') ? '_' + query : ''

            // download
            this.$root.download.saveFile(response, fileName + '.csv', 'text/csv')   // exports CSV
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

        // set today
        const now = new Date();
        const d = this.$root.utils.generic.padZero(now.getDate());
        const m = this.$root.utils.generic.padZero(now.getMonth() + 1);
        const y = now.getFullYear()

        this.filters.date_start = y + '-' + m + '-' + d;
        this.filters.date_end = y + '-' + m + '-' + d;

        this.list();                    // lists presenze
        this.listGiustificativi();       // lists giustificativi
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
