<template>
  <section class="content">
    <div class="container-fluid">

        <h3>Staff</h3>

        <div class="row">
          <div class="col-12">

            <div class="card" v-if="$gate.isAdminOrWebMaster()">
              <div class="card-header">
                <div class="card-title">

                </div>

                <div class="card-tools">

                  <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Aggiungi
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Tipo</th>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>Creato</th>
                      <th>Azioni</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="item in items.data" :key="item.id">

                      <td>{{ item.id }}</td>
                      <td class="text-capitalize">{{ item.type }}</td>
                      <td class="text-capitalize">{{ item.name }}</td>
                      <td>{{ item.email }}</td>
                      <td>{{ formatDate(item.created_at) }}</td>
                      <td>
                        <a href="#"
                            class="action"
                            @click="editModal(item)"
                            v-if="item.type != 'webmaster'"
                            >
                            <i class="fa fa-pen blue"></i>
                        </a>
                        <a href="#"
                            class="action"
                            @click="deleteItem(item.id)"
                            v-if="item.type != 'webmaster'"
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
                  <pagination :data="items" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- page not found to user but admin/webmaster -->
        <div v-if="!$gate.isAdminOrWebMaster()">
            <not-found></not-found>
        </div>

        <!-- Modal/Form -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Crea nuovo Utente</h5>
                    <h5 class="modal-title" v-show="editmode">Modifica Utente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- <form @submit.prevent="createUser"> -->
                <form @submit.prevent="editmode ? updateItem() : createItem()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nome</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="form.email" type="text" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input v-model="form.password" type="password" name="password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" autocomplete="false">
                            <has-error :form="form" field="password"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Ruolo Utente</label>
                            <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                <option value="">Seleziona Ruolo</option>
                                <option value="admin">Amministratore</option>
                                <option value="user">Utente Standard</option>
                            </select>
                            <has-error :form="form" field="type"></has-error>
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
import Vue from 'vue'
import VueMoment from 'vue-moment'

Vue.use(VueMoment)

export default {
    // #region Properties
    data () {
        return {
            editmode: false,
            items: {},
            form: new Form({
                id : '',
                type : '',
                name: '',
                email: '',
                password: '',
                email_verified_at: '',
            })
        }
    },
    // #endregion Properties

    methods: {
        getResults(page = 1) {
            this.$Progress.start();
            aaxios.get('api/user?page=' + page).then(({ data }) => (this.items = data.data));
            this.$Progress.finish()
        },

        // #region Modal Functions
        newModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        editModal(user){
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(user);
        },
        // #endregion Modal Functions

        // #region CRUD functions
        list(){
            // lists users
            const self = this
            this.$Progress.start();
            if(this.$gate.isAdminOrWebMaster()){
              axios.get("api/user").then(({ data }) => (this.items = data.data));
            }
            this.$Progress.finish()
        },
        createItem(){
            this.form.post('api/user')
            .then((response)=>{
                $('#addNew').modal('hide');
                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                });
                this.$Progress.finish();
                this.list();

            })
            .catch(()=>{
                Toast.fire({
                    icon: 'error',
                    title: 'Si è verificato un errore. Prego, riprova'
                });
            })
        },
        updateItem(){
            this.$Progress.start();
            this.form.put('api/user/'+this.form.id)
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
                html: "Confermi la cancellazione dell'utente?",
                showCancelButton: true,
                confirmButtonText: 'Si, procedi',
                cancelButtonText: 'Annulla'
                }).then((result) => {
                    // Send request to the server
                    if (result.value) {
                        this.form.delete('api/user/'+id).then(()=>{
                                Swal.fire(
                                'Eliminato!',
                                'Utente correttamente eliminato.',
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
        // #endregion CRUD functions

        // #region Utils Functions
        formatDate(date) {
            if (date==null) return ''
            return this.$moment(date).format('DD/MM/YYYY HH:mm:ss')
        }
        // #endregion Utils Functions
    },

    // #region Life Cycle
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
    // #endregion Life Cycle
}
</script>
