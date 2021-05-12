<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <h3>Presenze</h3>

            <div class="card">
              <div class="card-header">
                <div class="card-title">
                    <input v-model="filters.date" type="date" name="data_assunzione"
                        class="form-control"
                        :readonly="editmode"
                        :min="`2021-05-03`"
                        :max="formatDateISO(new Date())"
                        @change="list()"
                        title="Seleziona Data"
                    />
                </div>

                <div class="card-tools">
                  <button type="button" class="btn btn-sm btn-primary"
                    @click="functionNotAvailable()">
                      <i class="fa fa-plus-square"></i>
                      Aggiungi
                  </button>
                  <button type="button"
                    class="btn btn-sm btn-primary btn-green"
                    @click="functionNotAvailable()">
                      <i class="fa fa-file-excel"></i>
                      Esporta
                  </button>
                </div>
              </div>

              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Data / Ora</th>
                      <th>Dipendente</th>
                      <th>Timbrata</th>
                      <th>Veicolo</th>
                      <th>Dispositivo</th>
                      <th>Azioni</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="item in items" :key="item.id">
                      <td>{{ item.id }}</td>
                      <td>{{ formatDateTime(item.date_time) }}</td>
                      <td>{{ item.worker_nome_cognome }}</td>
                      <td>
                          <span class="badge"
                          :class="typeToClass(item.type)"
                          >{{ typeToString(item.type) }}</span>
                      </td>
                      <td>
                          <div v-if="item.mode == 2">
                              {{ item.veichle_model }} ({{ item.veichle_targa }})
                          </div>
                      </td>
                      <td>
                          <i class="fab fa-apple gray"
                            v-if="item.device_os == 'apple'"
                          ></i>
                          <i class="fab fa-android gray"
                            v-if="item.device_os == 'android'"
                          ></i>
                          {{ item.device_model }}
                      </td>
                      <td>
                        <a href="#"
                            class="action"
                            title="Modifica"
                            @click="functionNotAvailable(item)">
                            <i class="fa fa-pen blue"></i>
                        </a>
                        <a href="#"
                            class="action"
                            title="Elimina"
                            @click="functionNotAvailable(item.id)">
                            <i class="fa fa-trash blue"></i>
                        </a>
                        <a :href="'tracking/?session_id=' + item.tracking_session_id"
                            v-if="item.mode == 2"
                            class="action"
                            title="Visualizza Tragitto"
                            >
                            <i class="fas fa-map-marker-alt red" />
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="card-footer">
                  <pagination :data="items" @pagination-change-page="getResults"></pagination>
              </div>
            </div>

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
                                <option value="1">Su veicolo</option>
                                <option value="2">Manuale</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
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
import VueMoment from 'vue-moment'

Vue.use(VueMoment)

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
            filters: {
                date: this.formatDateISO(new Date())
            },
            autocompleteItems: [],
        }
    },
    filters: {
        truncate: function (text, length, suffix) {
            return text.substring(0, length) + suffix;
        },
    },
    computed: {
        filteredItems() {
        return this.autocompleteItems.filter(i => {
            return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
        });
        },
    },
    // #endregion Properties

    methods: {
        getResults(page = 1) {
            this.$Progress.start();
            axios.get('api/timbrata?page=' + page).then(({ data }) => (this.items = data.data));
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
            console.log(item)
            this.form.fill(item);
        },
        // #endregion Modals

        // #region CRUD Functions
        list() {
            const filters = 'filters_date=' + this.filters.date
            const order = 'order_by=date_time&order_dir=desc'
            axios.get("api/timbrata/?" + filters + '&' + order).then(({ data }) => (this.items = data.data));
        },
        createItem(){
            this.$Progress.start();

            this.form.post('api/timbrata')
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
            this.form.put('api/timbrata/' + this.form.id)
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
                text: "Prego, conferma la cancellazione del dipendente.",
                showCancelButton: true,
                confirmButtonText: 'Si, elimina',
                cancelButtonText: 'Annulla'
                }).then((result) => {
                    // Send request to the server
                    if (result.value) {
                        this.form.delete('api/timbrata/' + id).then(()=>{
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
        exportData() {
            alert('Questa funzione sarà disponibile a breve.')
            return
        },
        // #endregion CRUD Functions

        // #region Utils
        formatDate(date) {
            // formats date by moment DD/MM/YYY
            if (date==null) return ''
            return this.$moment(date).format('DD/MM/YYYY')
        },
        formatDateTime(date) {
            // formats date by moment DD/MM/YYY
            if (date==null) return ''
            return this.$moment(date).format('DD/MM/YYYY hh:mm:ss')
        },
        formatDateISO(date) {
            // formats date by moment
            if (date==null) return ''
            return this.$moment(date).format('YYYY-MM-DD')
        },
        typeToString(t) {
            // returns modo-timbtratura description
            switch (t) {
                case 'E': return 'entrata';
                case 'U': return 'uscita';
            }
        },
        typeToClass(t) {
            // returns modo-timbtratura description
            switch (t) {
                case 'E': return 'badge-success';
                case 'U': return 'badge-warning';
            }
        },
        functionNotAvailable() {
            alert('Questa funzione sarà disponibile a breve.')
            return
        }
        // #endregion utils
    },

    // #region Component Life Cycle
    mounted() {
    },
    created() {
        this.$Progress.start();
        this.list();
        this.$Progress.finish();
    },
    // #endregion Component Life Cycle
}
</script>
