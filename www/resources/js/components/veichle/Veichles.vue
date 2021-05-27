<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <h3>Veicoli</h3>

            <div class="card">
              <div class="card-header">
                <div class="card-title"></div>
                <!-- tools -->
                <div class="card-tools">
                  <button type="button" class="btn btn-sm btn-primary" @click="newModal()">
                      <i class="fa fa-plus-square"></i>
                      Aggiungi
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
                      <th>Marca</th>
                      <th>Modello</th>
                      <th>Targa</th>
                      <th>Abilitato</th>
                      <th>Azioni</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="item in items.data" :key="item.id">
                      <td style="width:20px;">
                          <i class="fa fa-dot-circle"
                            :title="(item.status==1 ? 'in circolazione' : 'in rimessa')"
                            :class="(item.status==1 ? 'green' : 'orange')"></i>
                      </td>
                      <td>{{ item.id }}</td>
                      <td>{{ item.manufacter }}</td>
                      <td>{{ item.model }}</td>
                      <td>{{ item.licence_plate }}</td>
                      <td>
                          <i class="fa fa-check green"
                            v-if="item.enabled==1"
                            :title="`Abilitato`"></i>
                          <i class="fa fa-minus-circle red"
                            v-if="item.enabled==0"
                            :title="`Non abilitato`"></i>
                      </td>
                      <td>
                        <a :href="'tracking/?session_id=' + item.tracking_session"
                            v-if="item.status == 1"
                            class="action"
                            title="Visualizza Tragitto"
                            >
                            <i class="fas fa-map-marker-alt red" />
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
                    <h5 class="modal-title" v-show="!editmode">Nuovo Veicolo</h5>
                    <h5 class="modal-title" v-show="editmode">Modifca Veicolo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateItem() : createItem()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Marca</label>
                            <input v-model="form.manufacter" type="text" name="manufacter"
                                class="form-control upper" :class="{ 'is-invalid': form.errors.has('manufacter') }"
                                :maxlength="128" :readonly="editmode"
                                >
                            <has-error :form="form" field="manufacter"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Modello</label>
                            <input v-model="form.model" type="text" name="model"
                                class="form-control upper" :class="{ 'is-invalid': form.errors.has('model') }"
                                :maxlength="128" :readonly="editmode"
                                >
                            <has-error :form="form" field="model"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Targa</label>
                            <input v-model="form.licence_plate" type="text" name="licence_plate"
                                class="form-control upper" :class="{ 'is-invalid': form.errors.has('licence_plate') }"
                                :maxlength="10" :readonly="editmode"
                                >
                            <has-error :form="form" field="licence_plate"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Abilitato</label>
                            <select name="enabled"
                                v-model="form.enabled"
                                class="form-control"
                                >
                                <option value="1">Si</option>
                                <option value="0">No</option>
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
                manufacter: '',
                model: '',
                licence_plate: '',
                enabled: 1
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
        return this.autocompleteItems.filter(i => {
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
            this.form.fill(item);
        },
        // #endregion Modals

        // #region CRUD Functions
        list(){
        // if(this.$gate.isAdmin()){
            axios.get("api/veicolo").then(({ data }) => (this.items = data.data));
        // }
        },
        createItem(){
            this.$Progress.start();

            this.form.post('api/veicolo')
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
            this.form.put('api/veicolo/' + this.form.id)
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
        deleteItem(id) {
            Swal.fire({
                title: 'Conferma',
                icon:'question',
                html: "Il veicolo verrà disabilitato, ma non eliminato, per consentire l'accesso ai dati di tracciamento acquisiti. Prego, conferma la disattivazione del veicolo.",
                showCancelButton: true,
                confirmButtonText: 'Si, procedi',
                cancelButtonText: 'Annulla'
                }).then((result) => {
                    // Send request to the server
                    if (result.value) {
                        this.form.delete('api/veicolo/' + id).then(()=>{
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

        // #region Utils
        formatDate(date) {
            // formats date by moment DD/MM/YYY
            if (date==null) return ''
            return this.$moment(date).format('DD/MM/YYYY')
        },
        dateAddDays(fromDate, days) {
            if (fromDate == null) return ''
            let ret = new Date()
            ret.setDate(fromDate.getDate() + days)
            return ret;
        },
        formatDateISO(date) {
            // formats date by moment
            if (date==null) return ''
            return this.$moment(date).format('YYYY-MM-DD')
        },
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
