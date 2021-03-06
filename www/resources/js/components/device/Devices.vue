<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <h3>{{ loadingTable ? `Dispositivi` : `Dispositivi` }}</h3>

            <div class="card">
              <div class="card-header">
                <!-- filters  -->
                <div class="card-title col-10">
                    <div class="row">
                        <div class="col-12">
                            <!--- filters here... -->
                        </div>
                    </div>
                </div>

                <!-- tools -->
                <div class="card-tools col-2 text-right">
                    <!-- tools here... -->
                </div>
              </div>

                <!-- body -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Marca e Modello</th>
                        <th>Sistema Operativo</th>
                        <th>Versione APP</th>
                        <th>Abilitato</th>
                        <th>UUID</th>
                        <th>Data Attivazione</th>
                        <th>Ultimo Accesso</th>
                        <th>Connessione</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="item in items.data" :key="item.id">
                        <td style="width:20px;">
                            <i class="fa fa-dot-circle"
                                :title="(item.is_online==1 ? 'online' : 'offline')"
                                :class="(item.is_online==1 ? 'green' : 'orange')"></i>
                        </td>
                        <td>{{ item.id }}</td>
                        <td>{{ item.manufacter }} {{ item.model }}</td>
                        <td>
                            <i class="fab fa-apple gray"
                                v-if="item.platform.toLowerCase() == 'apple'"
                            ></i>
                            <i class="fab fa-android gray"
                                v-if="item.platform.toLowerCase() == 'android'"
                            ></i>
                            {{ item.platform }} {{ item.version }}
                        </td>
                        <td>
                            {{ item.app_version }}
                            <a href="#"
                                v-if="item.app_version !== lastAppVersion"
                                class="action ml-2"
                                title="Aggiornamento App Richiesto"
                                @click="appUpgradeRequired(item)"
                                >
                                <i class="fas fa-exclamation-triangle red"></i>
                            </a>
                        </td>
                        <td>
                            <i class="fa fa-check green"
                                v-if="item.enabled==1"
                                :title="`Abilitato`"></i>
                            <i class="fa fa-minus-circle red"
                                v-if="item.enabled==0"
                                :title="`Non abilitato`"></i>
                        </td>
                        <td>{{ item.uuid }}</td>
                        <td>{{ $root.utils.datetime.formatDateTime(item.created_at) }}</td>
                        <td>{{ $root.utils.datetime.formatDateTime(item.updated_at) }}</td>
                        <td>
                            <i class="fas fa-wifi"
                                :title="item.connection_type"
                                v-if="item.connection_type === 'wifi'"></i>
                            <i class="fas fa-sim-card"
                                :title="item.connection_type"
                                v-if="item.connection_type === 'cellular'"></i>
                            <i class="fas fa-ethernet"
                                :title="item.connection_type"
                                v-if="item.connection_type != 'wifi' && item.connection_type != 'cellular'"></i>
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="card-footer">
                  <pagination
                    :data="items" @pagination-change-page="getResults"
                    :limit=10
                  ></pagination>
              </div>
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
            autocompleteItems: [],
        }
    },
    filters: {
    },
    computed: {
        lastAppVersion() {
            // returns the last APP release version number
            return process.env.MIX_APP_VERSION
        }
    },
    // #endregion Properties

    methods: {
        getResults(page = 1) {
            this.$Progress.start()
            this.loadingTable = true
            axios.get('api/device?page=' + page).then(({ data }) => {
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
            console.log(item)
            this.form.fill(item);
        },
        // #endregion Modals

        appUpgradeRequired(item) {
            console.log(item)
            const msg = `Il dispositivo ${item.manufacter} ${item.model} (${item.platform} ${item.version}) sta usando una <b>versione obsoleta dell'App, che non supporta l'aggiornamento automatico..<br><br><span>Per aggiornare manualmente il dispositivo alla versione ${this.lastAppVersion} dell'App:<br>- accedere a "Impostazioni/Installa APP" su questo sito<br>- scansionare il QRCode con la fotocamera del dispositivo<br>- seguire la procedura di download e installazione dell'App sul telefono.</span>`;
            Swal.fire({
                title: 'Aggiornamento Richiesto',
                icon:'warning',
                html: msg,
                confirmButtonText: 'Ok',
                customClass: 'swal-wide',
            })
        },

        // #region CRUD Functions
        list() {
            this.$Progress.start()
            this.loadingTable = true
            axios.get("api/device").then(({ data }) => {
                this.items = data.data
                this.$Progress.finish()
                this.loadingTable = false
            });
        },
        createItem(){
            this.$Progress.start();

            this.form.post('api/device')
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
            this.form.put('api/device/' + this.form.id)
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
                html: "Il dispositivo verrà disabilitato, ma non eliminato, per consentire l'accesso ai dati di tracciamento acquisiti. Prego, conferma la disattivazione del dispositivo.",
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
        exportData() {
            alert('Questa funzione sarà disponibile a breve.')
            return
        },
        // #endregion CRUD Functions

        // #region Utils
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
