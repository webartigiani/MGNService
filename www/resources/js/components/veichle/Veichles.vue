<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <h3>{{ loadingTable ? `Veicoli` : `Veicoli` }}</h3>

            <div class="card">
              <div class="card-header">
                <!-- filters  -->
                <div class="card-title col-10">
                    <div class="row">
                        <div class="col-12">
                            <!-- filters here... -->
                        </div>
                    </div>
                </div>

                <!-- tools -->
                <div class="card-tools col-2 text-right">
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
                            :title="(item.status==1 ? 'in circolazione' : 'in sosta')"
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
                        <!--
                        <a :href="'tracking/?session_id=' + item.tracking_session"
                            v-if="item.status == 1"
                            class="action"
                            title="Visualizza Tragitto"
                            >
                            <i class="fas fa-map-marker-alt red" />
                        </a>
                        -->
                        <a href="#"
                            class="action"
                            title="Modifica"
                            @click="editModal(item)">
                            <i class="fa fa-pen blue"></i>
                        </a>
                        <a href="#"
                            class="action"
                            title="Disabilita"
                            @click="deleteItem(item)"
                            v-if="item.enabled == 1"
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
                manufacter: '',
                model: '',
                licence_plate: '',
                enabled: 1
            }),
            autocompleteItems: [],
        }
    },
    filters: {
    },
    computed: {
    },
    // #endregion Properties

    methods: {
        getResults(page = 1) {
            this.$Progress.start()
            this.loadingTable = true
            axios.get('api/worker?page=' + page).then(({ data }) => {
                this.items = data.data
                this.loadingTable = false
                this.$Progress.finish()
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
        list(){
            this.$Progress.start()
            this.loadingTable = true
            axios.get("api/veicolo").then(({ data }) => {
                this.items = data.data
                this.loadingTable = false
                this.$Progress.finish()
            });
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
        deleteItem(item) {
            let msg = "Il veicolo verrà disabilitato ma non eliminato, per consentire l'accesso ai dati di tracciamento già acquisiti. I veicoli disabilitati non sono utilizzabili tramite APP. Potrai abilitare nuovamente il veicolo, tramite pulsante modifica su questa pagina.<br><br>";
            msg += "Disabilitare il veicolo<br>" + item.manufacter + ' ' + item.model + "<br>con targa " + item.licence_plate + ' ?';
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
                        this.form.delete('api/veicolo/' + item.id).then(()=>{
                            Swal.fire(
                                'Disabilitato!',
                                'Veicolo correttamente disabilitato.',
                                'success'
                            );
                            // Fire.$emit('AfterCreate');
                            this.list();
                        }).catch((data)=> {
                            Swal.fire("Errore!", data.message, "warning");
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
