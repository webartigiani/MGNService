<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <h3>{{ loadingTable ? `Dipendenti` : `Dipendenti` }}</h3>

            <div class="card">
                <div class="card-header">
                    <!-- tools -->
                    <div class="card-tools col-12 text-right">
                        <button type="button"
                            class="btn btn-sm btn-primary"
                            title="Aggiungi un dipendente"
                            @click="newModal()">
                            <i class="fa fa-plus-square"></i>
                            Aggiungi
                        </button>
                        <button type="button"
                            class="btn btn-sm btn-primary btn-green"
                            title="Esporta Anagrafica Dipendenti"
                            @click="exportData()">
                            <i class="fa fa-file-excel"></i>
                            Esporta
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
                                <label for="hiring_date_start">Periodo</label>
                                <input
                                    v-model="filters.hiring_date_start"
                                    type="month"
                                    id="hiring_date_start"
                                    class="form-control"
                                    :min="`2019-01`"
                                    :max="$root.utils.datetime.formatDateISO(new Date())"
                                    @change="list()"
                                    title="Inizio Periodo"
                                />
                                <input
                                    v-model="filters.hiring_date_end"
                                    type="month"
                                    class="form-control"
                                    :min="`2019-01`"
                                    :max="$root.utils.datetime.formatDateISO(new Date())"
                                    @change="list()"
                                    title="Fine Periodo"
                                />

                                &nbsp;&nbsp;
                                <label for="hiring_status">Assunzione</label>
                                <select name="hiring_status" id="hiring_status"
                                    class="form-control"
                                    v-model="filters.hiring_status"
                                    @change="list()"
                                    >
                                    <option value="-1">-- tutti --</option>
                                    <option value="1">Assunti</option>
                                    <option value="0">Cessati</option>
                                </select>

                                &nbsp;&nbsp;
                                <label for="status">Presenza</label>
                                <select name="status" id="status"
                                    class="form-control"
                                    v-model="filters.status"
                                    @change="list()"
                                    >
                                    <option value="-1">-- tutti --</option>
                                    <option value="1">Presente ora</option>
                                    <option value="0">Assente ora</option>
                                </select>

                                <button type="button"
                                    class="btn btn-sm btn-primary"
                                    title="Resetta Filtri"
                                    @click="resetFilters()">
                                    Cancella Filtri
                                </button>
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
                            <th style="width:20px;"></th>
                            <th style="width:20px;">ID</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Matricola</th>
                            <th>Codice Fiscale</th>
                            <th>Uso Veicolo</th>
                            <th>Codice Timbrata</th>
                            <th style="width:100px;">Ore Sett.</th>
                            <th>Data Assunzione</th>
                            <th>Data Cessazione</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in items.data" :key="item.id">
                        <td>
                            <i class="fa fa-dot-circle"
                                :title="(item.stato==1 ? 'attualmente presente' : 'attualmente assente')"
                                :class="(item.stato==1 ? 'green' : 'orange')"></i>
                        </td>
                        <td>{{ item.id }}</td>
                        <td>{{ item.nome}}</td>
                        <td>{{ item.cognome}}</td>
                        <td>{{ item.matricola}}</td>
                        <td>{{ item.codice_fiscale}}</td>
                        <td>
                            <span class="badge"
                            :class="modoTimbraturaToClass(item.modo_timbratura)"
                            >{{ modoTimbraturaToString(item.modo_timbratura) }}</span>
                        </td>
                        <td>{{ item.password_timbratura }}</td>
                        <td>{{ item.ore_settimanali }}</td>
                        <td>{{ $root.utils.datetime.formatDate(item.data_assunzione) }}</td>
                        <td>{{ $root.utils.datetime.formatDate(item.data_cessazione) }}</td>
                        <td>
                            <a href="#"
                                class="action"
                                title="Modifica"
                                @click="editModal(item)">
                                <i class="fa fa-pen blue"></i>
                            </a>
                            <a href="#"
                                class="action"
                                title="Elimina"
                                @click="deleteItem(item)">
                                <i class="fa fa-trash blue"></i>
                            </a>
                        </td>
                        </tr>
                    </tbody>
                    </table>
                </div>

                <!-- footer -->
                <div class="card-footer">
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
                            <label>Indirizzo Email</label>
                            <input v-model="form.email" type="email" name="email"
                                class="form-control lower" :class="{ 'is-invalid': form.errors.has('email') }"
                                :maxlength="64"
                                >
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Telefono</label>
                            <input v-model="form.telefono" type="tel" name="telefono"
                                class="form-control lower" :class="{ 'is-invalid': form.errors.has('telefono') }"
                                :maxlength="64"
                                >
                            <has-error :form="form" field="telefono"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Matricola</label>
                            <input v-model="form.matricola" type="text" name="matricola"
                                class="form-control upper"
                                :class="{ 'is-invalid': form.errors.has('matricola') }"
                                :maxlength="16" :readonly="editmode"
                                >
                            <has-error :form="form" field="matricola"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Uso Veicolo</label>
                            <select name="modo_timbratura"
                                v-model="form.modo_timbratura"
                                class="form-control"
                                >
                                <option value="0">entrambi</option>
                                <option value="1">Veicolo Aziendale</option>
                                <option value="2">Veicolo Proprio</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ore Settimanali</label>
                            <input type="number" name="ore_settimanali" id="ore_settimanali"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('ore_settimanali') }"
                                min="1" max="60"
                                required
                                v-model="form.ore_settimanali">
                            <has-error :form="form" field="ore_settimanali"></has-error>
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
            loadingTable: true,
            editmode: false,
            items : {},
            form: new Form({
                id : '',
                nome: '',
                cognome: '',
                codice_fiscale: '',
                email: '',
                telefono: '',
                matricola: '',
                modo_timbratura: 0,
                ore_settimanali: 1,
                data_assunzione: '',
                data_cessazione: ''
            }),
            // filters
            filters: {
                show: false,
                hiring_status: -1,
                status: -1,
                hiring_date_start: null,
                hiring_date_end: null
            },
        }
    },
    filters: {
    },
    computed: {
        filteredItems() {
            return this.items.filter(i => {
                return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
        },
    },
    // #endregion Properties

    methods: {
        getResults(page = 1) {
            this.$Progress.start()
            this.loadingTable = true
            let params = this.filters                           // appends filters and search
            params.query = this.$root.$route.query.search
            axios.get('api/worker?page=' + page, {
                params: params
            }).then(({ data }) => {
                this.items = data.data
                this.$Progress.finish()
                this.loadingTable = false
            });
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
            this.$Progress.start()
            this.loadingTable = true
            let params = this.filters                           // appends filters and search
            params.query = this.$root.$route.query.search
            axios.get('api/worker', {
                params: params
            }).then(({ data }) => {
                this.items = data.data
                this.$Progress.finish()
                this.loadingTable = false
            });
        },
        createItem(){
            this.$Progress.start();

            this.form.post('api/worker')
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
            this.form.put('api/worker/'+this.form.id)
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
        deleteItem(item) {
            let msg = 'Il dipendente verrà eliminato e non potrà più effettuare timbrate, nè utilizzare l\'APP MGN.<br><br>';
            msg += 'Eliminare il dipendente<br>' + item.nome + ' ' + item.cognome + '?';
            Swal.fire({
                title: 'Conferma',
                icon:'question',
                html: msg,
                showCancelButton: true,
                confirmButtonText: 'Si, procedi',
                cancelButtonText: 'Annulla'
                }).then((result) => {
                    // Send request to the server
                    if (result.value) {
                        this.form.delete('api/worker/' + item.id).then(()=>{
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
                url: 'api/workers/export',
            })
            // choose filename
            const fileName = 'ELEDIP'
            this.$root.download.saveFile(response, fileName + '.csv', 'text/csv')   // exports CSV
            this.$Progress.finish();
        },
        // #endregion Export Functions

        // #region Filters Functions
        resetFilters() {
            // resets filters
            this.filters.hiring_status = -1
            this.filters.status = -1
            this.filters.hiring_date_start = ''
            this.filters.hiring_date_end = ''
            this.$root.$route.query.search = ''
            this.list()
        },
        // #endregion Filters Functions

        // #region Utils
        modoTimbraturaToString(modo) {
            // returns modo-timbtratura description
            switch (modo) {
                case 0: return 'entrambi';
                case 1: return 'veicolo aziendale';
                case 2: return 'veicolo proprio';
            }
        },
        modoTimbraturaToClass(modo) {
            // returns modo-timbtratura description
            switch (modo) {
                case 0: return 'badge-success';
                case 1: return 'badge-warning';
                case 2: return 'badge-info';
            }
        },
        // #endregion utils
    },

    // #region Component Life Cycle
    beforeCreate() {
    },
    created() {
        this.$Progress.start();
        this.list();
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
