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
                    <!-- #region tools -->
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
                            @click="exportXML()">
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
                    <!-- #endregion tools -->
                </div>

                <!-- #region filters -->
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
                <!-- #endregion filters -->

              <!-- body -->
              <div class="card-body table-responsive p-0">
                <!-- #region DataTable -->
                <table class="table table-hover">
                  <thead
                    v-show="items.data.length > 0"
                    >
                    <tr>
                      <th></th>
                      <th>Data</th>
                      <th><!-- day name --></th>
                      <th>Nome</th>
                      <th>Cognome</th>
                      <th><!-- Presenza --></th>
                      <th>Entrata</th>
                      <th>Uscita</th>
                      <th>Rientro</th>
                      <th>Uscita</th>
                      <th class="ore">Presenza</th>
                      <th class="ore">Lavorate</th>
                      <th class="ore">Da Contratto</th>
                      <th class="ore">Assenza</th>
                      <th class="ore">Straordinarie</th>
                      <th><!-- giustificativo assenza/straordinari --></th>
                      <!-- <th>Totali</th> -->
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
                        <td>{{ item.day_date }}</td>
                        <td>{{ dayName(item) }}</td>
                        <td><a :href="linkWorker(item)">{{ item.nome }}</a></td>
                        <td><a :href="linkWorker(item)">{{ item.cognome }}</a></td>
                        <td><!-- stato presenza -->
                            <span class="badge"
                            :class="presenzaToClass(item)"
                            >{{ presenzaString(item) }}</span>
                        </td>
                        <!-- 1* entrata, 1* uscita, 2* entrata, 2* uscita -->
                        <td>{{ attendanceTime(item.day_date, item.entrance_date) }}</td>
                        <td>{{ attendanceTime(item.day_date, item.exit_date) }}</td>
                        <td>{{ attendanceTime(item.day_date, item.entrance_date_2) }}</td>
                        <td>{{ attendanceTime(item.day_date, item.exit_date_2) }}</td>

                        <!-- ore presenza, lavorate -->
                        <td class="ore">{{ $root.utils.generic.padZero(item.duration_h_int) + ':' + $root.utils.generic.padZero(item.residual_m) }}</td>
                        <td class="ore">{{ $root.utils.generic.padZero(item.duration_h_int) + ':' + $root.utils.generic.padZero(item.residual_m_int) }}</td>
                        <!-- ore da contratto -->
                        <td class="ore">
                            <span>{{ $root.utils.generic.padZero(item.worker_day_hours) + ':00' }}</span>
                        </td>
                        <!-- ore Assenza (giustificata) -->
                        <td class="ore">
                            <span
                            v-if="item.abscence_justification != ''"
                            >{{ $root.utils.generic.padZero(item.abscence_h_int) + ':' + $root.utils.generic.padZero(item.abscence_minutes_int) }}
                            </span>
                        </td>

                        <!-- ore Straordinario (giustificato) -->
                        <td class="ore">
                            <span
                            v-if="item.extraordinary_justification != ''"
                            :title="item.extraordinary_justification_desc"
                            >{{ $root.utils.generic.padZero(item.extraordinary_h_int) + ':' + $root.utils.generic.padZero(item.extraordinary_minutes_int) }}
                            </span>
                            <!-- abilita pulsante gestione straordinari,
                                 se i minuti lavorati eccedono le ore di lavoro da contratto
                                 e NON è presente un giustificativo dello straordinario
                            -->
                            <a href="#"
                                v-if="item.cont_m > (item.worker_day_hours*60) && item.extraordinary_justification === ''"
                                class="action"
                                title="Gestisci Straordinari"
                                @click="addEditExtra(item)"
                                >
                                <i class="fa fa-clock red big"></i>
                            </a>
                        </td>
                        <!-- giustificativo assenz/straordinario -->
                        <td>
                            <span class="badge"
                                v-if="item.abscence_justification != '' && item.abscence_justification != '_R'"
                                :class="assenzaToClass(item)"
                            >{{ item.abscence_justification_desc.replace('* ', '') }}</span>
                            <span class="badge"
                                v-if="item.extraordinary_justification != ''"
                                :class="straordinarioToClass(item)"
                            >{{ item.extraordinary_justification_desc }}</span>
                        </td>
                        <!-- ore totali
                        <td class="ore">{{ $root.utils.generic.padZero(item.total_h_int) + ':' + $root.utils.generic.padZero(item.total_minutes_int) }}</td>
                         -->

                        <!-- actions -->
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
                                title="Giustifica Assenza"
                                @click="addEditAbscence(item)"
                                >
                                <i class="fa fa-balance-scale"
                                    :class="(item.abscence_justification != '') ? `blue` : `gray`"
                                ></i>
                            </a>
                            <!-- abilita pulsante gestione straordinari,
                                 se i minuti lavorati eccedono le ore di lavoro da contratto
                                 e NON è presente un giustificativo dello straordinario
                            -->
                            <a href="#"
                                v-if="item.cont_m > (item.worker_day_hours*60)"
                                class="action"
                                title="Gestisci Straordinari"
                                @click="addEditExtra(item)"
                                >
                                <i class="fa fa-clock"
                                    :class="(item.extraordinary_justification != '') ? `blue` : `red`"
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

                  <!-- table footer -->
                  <tfoot
                    v-show="items.data.length > 0"
                  >
                    <tr>
                      <td></td>
                      <td><!-- Data --></td>
                      <td><!-- Day Name --></td>
                      <td><!-- Nome --></td>
                      <td><!-- Cognome --></td>
                      <td><!-- Presenza --></td>
                      <td><!-- Entrata --></td>
                      <td><!-- Uscita --></td>
                      <td><!-- Rientro --></td>
                      <td><!-- Uscita --></td>
                      <td class="ore total">{{ totalPresenza() }}</td>
                      <td class="ore total">{{ totalLavorate() }}</td>
                      <td class="ore total">{{ totalContratto() }}</td>
                      <td class="ore total">{{ totalAssenza() }}</td>
                      <td class="ore total">{{ totalStaordinarie() }}</td>
                      <td class=""><!-- giustificativo assenza/straordinari --></td>
                      <!-- <td class="ore total">Totali</td> -->
                      <td><!-- Azioni --></td>
                    </tr>
                  </tfoot>
                </table>
                <!-- #endregion DataTable -->
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

        <!-- #region Editor Modal/Form -->
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
        <!-- #endregion Editor Modal/Form -->

        <!-- #region Abscence Editor -->
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
                            <label for="abscence_justification">Giustificativo Assenza</label>
                            <select name="abscence_justification" id="abscence_justification"
                                class="form-control"
                                required
                                v-model="form.abscence_justification"
                                >
                                <option value="">-seleziona-</option>
                                <option :value="item.code"
                                    v-for="item in giustificativi_assenze" :key="item.code"
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
        <!-- #endregion Abscence Editor -->

        <!-- #region Extra (Straordinari) Editor -->
        <div class="modal fade" id="modalExtra" tabindex="-1" role="dialog" aria-labelledby="modalExtra" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gestisci Straordinari</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="upsertExtraordinary()">
                    <div class="modal-body">
                        <div class="form-group">
                            <b>
                            {{ form.nome }} {{ form.cognome }}<br>
                            {{ form.day_date }}
                            </b>
                        </div>

                        <div class="form-group">
                            <label for="extraordinary_time">Ore di Straordinario</label>
                            <input type="time" name="extraordinary_time"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('extraordinary_time') }"
                                step="900"
                                v-model="form.extraordinary_time"
                                required
                                >
                            <has-error :form="form" field="extraordinary_time"></has-error>
                        </div>
                        <div class="form-group">
                            <label for="extraordinary_justification">Giustificativo Straordinari</label>
                            <select name="extraordinary_justification" id="extraordinary_justification"
                                class="form-control"
                                required
                                v-model="form.extraordinary_justification"
                                >
                                <option value="">-seleziona-</option>
                                <option :value="item.code"
                                    v-for="item in giustiticativi_straordinari" :key="item.code"
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
        <!-- #endregion Extra (Straordinari) Editor -->

        <!-- #region Notes Editor -->
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
        <!-- #endregion Notes Editor -->
    </div>
  </section>
</template>

<style scoped>
a.action {
    margin-right:5px!important;
}
i.big {
    font-size: 2em;
}
.badge {
  padding: 0.4em 0.8em;
}
table {
    font-size: .9em;
}
th.ore {
    background-color:rgba(0, 0, 0, 0.135);
    text-align: center;
}
td.ore {
    background-color:rgba(0, 0, 0, 0.035);
    text-align: center;
}
td.ore.total {
    background-color:rgba(0, 0, 0, 0.135);
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
import moment from 'moment'

export default {
    components: {
        VueTagsInput,
    },

    // #region Properties
    data () {
        return {
            editmode: false,
            items : {},
            giustificativi_assenze: [],
            giustiticativi_straordinari: [],

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

                extraordinary_minutes: '',
                extraordinary_justification: '',
                extraordinary_time: '00:00',
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
            // Adds/Edits Abscence minutes
            this.editmode = false;
            this.form.reset();
            $('#modalAbscences').modal('show');
            this.form.fill(item);

            // calculates abscence_time
            this.form.abscence_time = this.$root.utils.generic.padZero(item.abscence_h_int) + ':' + this.$root.utils.generic.padZero(item.abscence_minutes_int)
        },
        addEditExtra(item) {
            // Adds/Edits Extra (Straordinari) minutes
            this.editmode = false;
            this.form.reset();
            $('#modalExtra').modal('show');
            this.form.fill(item);

            // calculates extraordinary_time
            let extra_time = '00:00'                    // extra time predefinito

            // calcola ore e minuti straordinari da rilevamento ore,
            // basandosi sulle ore lavorative da calendario
            let extra = parseInt(item.cont_m - (item.worker_day_hours*60))
            if (extra > 0) {
                const extra_h = Math.floor(extra / 60)
                const extra_m = extra % 60
                extra_time = this.$root.utils.generic.padZero(extra_h) + ':' + this.$root.utils.generic.padZero(extra_m)
            } else {
                // calcola ore e minuti straordinari, da giustificativo
            }

            this.form.extraordinary_time = extra_time
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
        hasToJustifyExtraOrdinaries() {
            const r = this.items.data.filter((item) => {
                return ((item.cont_m > parseFloat(item.avg_minutes_per_day)) && (item.extraordinary_justification === ''))
            })
            return (r.length > 0)
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

        // #region CRUD Assenze, Straordinari, Note
        upsertAbscence() {
            // inserts/updates abscence
            this.$Progress.start();

            this.form.post('api/abscence')
                .then((response)=>{
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
        upsertExtraordinary() {
            // inserts/updates extra-orinary
            this.$Progress.start();

            this.form.post('api/extra-ordinary')
                .then((response)=>{
                    if(response.data.success) {
                        $('#modalExtra').modal('hide');
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
        // #endregion CRUD Assenze, Straordinari, Note

        // #endregion CRUD Functions

        // #region Total Functions
        totalPresenza() {
            // restituisce ore:minuti totali presenza
            let mins = 0

            this.items.data.forEach((element) => {
                mins += (element.duration_h_int * 60) + element.residual_m
            })

            const h = Math.floor(mins / 60)
            const m = (mins % 60)
            return `${this.$root.utils.generic.padZero(h)}:${this.$root.utils.generic.padZero(m)}`
        },
        totalLavorate() {
            // restituisce ore:minuti totali lavorate
            let mins = 0

            this.items.data.forEach((element) => {
                mins += (element.duration_h_int * 60) + element.residual_m_int
            })

            const h = Math.floor(mins / 60)
            const m = (mins % 60)
            return `${this.$root.utils.generic.padZero(h)}:${this.$root.utils.generic.padZero(m)}`
        },
        totalContratto() {
            // restituisce ore:minuti totali lavorate
            let mins = 0

            this.items.data.forEach((element) => {
                mins += (element.worker_day_hours * 60) + 0
            })

            const h = Math.floor(mins / 60)
            const m = (mins % 60)
            return `${this.$root.utils.generic.padZero(h)}:${this.$root.utils.generic.padZero(m)}`
        },
        totalAssenza() {
            // restituisce ore:minuti totali assenze
            let mins = 0

            this.items.data.forEach((element) => {
                if (element.abscence_justification !== '')
                    mins += (element.abscence_h_int * 60) + element.abscence_minutes_int
            })

            const h = Math.floor(mins / 60)
            const m = (mins % 60)
            return `${this.$root.utils.generic.padZero(h)}:${this.$root.utils.generic.padZero(m)}`
        },
        totalStaordinarie() {
            // restituisce ore:minuti totali assenze
            let mins = 0

            this.items.data.forEach((element) => {
                if (element.extraordinary_justification !== '')
                    mins += (element.extraordinary_h_int * 60) + element.extraordinary_minutes_int
            })

            const h = Math.floor(mins / 60)
            const m = (mins % 60)
            return `${this.$root.utils.generic.padZero(h)}:${this.$root.utils.generic.padZero(m)}`
        },
        // #endregion Total Functions

        // #region Other Data Functions
        listGiustificativiAssenze() {
            axios.get('api/attendances/giustificativi-assenze', {}).then(({ data }) => {
                this.giustificativi_assenze = data
            });
        },
        listGiustificativiStraordinari() {
            axios.get('api/attendances/giustificativi-straordinari', {}).then(({ data }) => {
                this.giustiticativi_straordinari = data
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
        exportXML() {
            if (this.hasToJustifyExtraOrdinaries()) {
                const msg = "Sono richieste correzioni. Nell'\intervallo di date selezionato sono presenti ore di lavoro straordinarie non giustificate.<br><br>Correggere il foglio presenze giustificando le ore straordinarie, o modificando le timbrate fino al raggiungimento delle ore lavorative previste da contratto.";

                Swal.fire({
                    title: 'Attenzione',
                    icon:'warning',
                    html: msg,
                    showCancelButton: true,
                    confirmButtonText: 'Esporta senza correzioni',
                    cancelButtonText: 'Annulla'
                    }).then((result) => {
                        // Exports XML
                        if (result.value) this.exportDataXML()
                    })
            } else {
                this.exportDataXML()
            }
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
        linkWorker(item) {
            return `attendances?search=${item.nome}%20${item.cognome}`
        },
        dayName(item) {
            let dn = moment(item.ref_date).locale("it").format('dddd')
            dn = dn.substr(0, 3) + '.'
            return dn
        },
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
                        case '_R': return 'badge-success';      // non viene mostrato badge
                    }
                case 0: return 'badge-warning';
                case 1: return 'badge-warning';
            }
        },
        straordinarioToClass(item) {
            // returns straordinario class
            return 'badge-success';
        },
        attendanceTime(dayDate, t) {
            if (t == null) return ''
            if (dayDate == '') return ''
            return t.replace(dayDate, '')   //.trim().substr(0, 5)
        }
        // #endregion utils
    },
    // #endregion Methods

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

        this.list();                            // lists presenze
        this.listGiustificativiAssenze();       // lists giustificativi assenze
        this.listGiustificativiStraordinari();  // lista giustificativi straordinari
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
