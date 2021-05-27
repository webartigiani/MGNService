<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <h3>Dipendenti</h3>

            <div class="card">
              <div class="card-header">
                <div class="card-title">
                </div>
                <!-- tools -->
                <div class="card-tools">
                  <button type="button" class="btn btn-sm btn-primary" @click="newModal()">
                      <i class="fa fa-plus-square"></i>
                      Aggiungi
                  </button>
                  <button type="button"
                    class="btn btn-sm btn-primary btn-green"
                    @click="exportData()">
                      <i class="fa fa-file-excel"></i>
                      Esporta
                  </button>
                </div>
              </div>
              <!-- body -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th></th>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Cognome</th>
                      <th>Matricola</th>
                      <th>Codice Fiscale</th>
                      <th>Modo Timbrata</th>
                      <th>Codice Timbrata</th>
                      <th>Data Assunzione</th>
                      <th>Data Cessazione</th>
                      <th>Azioni</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="item in items.data" :key="item.id">
                      <td style="width:20px;">
                          <i class="fa fa-dot-circle"
                            :title="(item.stato==1 ? 'presente' : 'non presente')"
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
                      <td>{{ item.password_timbratura}}</td>
                      <td>{{ $root.utils.datetime.formatDate(item.data_assunzione) }}</td>
                      <td>{{ $root.utils.datetime.formatDate(item.data_cessazione) }}</td>
                      <td>
                        <a href="#"
                            class="action"
                            title="Visualizza Timbrate"
                            @click="$root.utils.generic.functionNotAvailable()"
                            >
                            <i class="fa fa-tag blue"></i>
                        </a>
                        <a href="#"
                            class="action"
                            title="Modifica"
                            @click="editModal(item)">
                            <i class="fa fa-pen blue"></i>
                        </a>
                        <a href="#"
                            class="action"
                            title="Elimina"
                            @click="deleteItem(item.id)">
                            <i class="fa fa-trash blue"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="items" @pagination-change-page="getResults"></pagination>
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
            return this.items.filter(i => {
                return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
        },
    },
    // #endregion Properties

    methods: {
        getResults(page = 1) {
            this.$Progress.start();
            axios.get('api/worker?page=' + page).then(({ data }) => (this.items = data.data));
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
        list(){
        // if(this.$gate.isAdmin()){
            axios.get('api/worker').then(({ data }) => (this.items = data.data));
        // }
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
                        this.form.delete('api/worker/'+id).then(()=>{
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
        modoTimbraturaToString(modo) {
            // returns modo-timbtratura description
            switch (modo) {
                case 0: return 'tutte';
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
    },
    beforeDestroy() {

    },
    destroyed() {

    }
    // #endregion Component Life Cycle
}
</script>
