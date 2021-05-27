<!--
    accesso_dipendenti
-->
<template>
    <div>
        <form @submit.prevent="timbra()">
            <input type="hidden" name="source" v-model="form.source" />

            <div class="modal-body">
                <VueClock />

                <div class="form-group">
                    <select
                        name="worker"
                        v-model="form.worker"
                        class="form-control"
                        >
                        <option value="">- SELEZIONA NOMINATIVO -</option>
                        <option v-for="item in workers" :value="item" :key="item.id">
                        {{ item.name }} {{ item.surname }}
                        </option>
                    </select>
                    <has-error :form="form" field="worker"></has-error>
                </div>
                <div class="form-group">
                <input v-model="form.codice_timbrata" type="text" name="codice_timbrata"
                    placeholder="- Codice Timbrata -"
                    autocomplete="off"
                    class="form-control upper"
                    :maxlength="10"
                    >
                </div>
                <has-error :form="form" field="codice_timbrata"></has-error>
            </div>
            <div class="modal-footer">
                <button type="submit"
                class="btn btn-success btn-lg button"
                :disabled="loading || posting"
                ><i class="fa fa-spinner fa-spin spinner"
                    v-if="loading || posting"
                ></i>Timbra</button>
            </div>
        </form>
    </div>
</template>

<style scoped>
button.button {
    width: 100%;
}
.spinner {
    margin-right: 10px;
}
</style>

<script>
import Vue from 'vue';

/**
 * @dangvanthanh/vue-clock
 * source:      https://github.com/dangvanthanh/vue-clock
 * install:     npm install @dangvanthanh/vue-clock --save
 * notes:       to customize see "Customizations.md"
 */
import VueClock from '@dangvanthanh/vue-clock';
Vue.use(VueClock);

export default {
    components: {
        VueClock
    },

    // #region Properties
    data() {
        return {
            loading: true,
            posting: false,
            workers: [],
            form: new Form({
                worker : '',
                codice_timbrata: '',
                source: 'accesso_dipendenti'
            }),
        }
    },
    // #endregion Properties

    // #region Component Life Cycle
    beforeCreate() {
    },
    created() {
        // lists workers
        axios.get("api/ws/workers/list/").then(({ data }) => (
            this.workers = data.data
        ));
    },
    beforeMount() {
    },
    mounted() {
        this.loading = false
    },
    beforeDestroy() {
    },
    destroyed() {
    },
    // #endregion Component Life Cycle

    // #region Methods
    methods: {
        timbra() {
            // #region Form Validation
            if (typeof this.form.worker == 'string') {
                Swal.fire({
                    title: 'Errore',
                    icon: 'error',
                    html: 'Seleziona il tuo nominativo e ripeti la timbrata'
                });
                return;
            }
            if (this.form.codice_timbrata == '') {
                Swal.fire({
                    title: 'Errore',
                    icon: 'error',
                    html: 'Inserisci il tuo codice e ripeti la timbrata'
                });
                return;
            }
            // #endregion Form Validation

            // #region API Post
            this.posting = true
            this.form.post('api/website/workers/timbra').then((result) => {
                // API Succeded
                const response = result.data
                const data = result.data.data

                console.log(data);

                if (response.success) {
                    // timbrata OK
                    let title = ''
                    let msg = this.form.worker.name + ' ' + this.form.worker.surname

                    if (data.check == 0) {
                        // entrance
                        title = 'Entrata'
                        msg = this.form.worker.name + ' ' + this.form.worker.surname
                        msg += '<br><br>timbrata entrata alle ore ' + this.formatTime(data.entrance_date)
                    }
                    if (data.check == 1) {
                        // exit
                        title = 'Uscita'
                        msg = this.form.worker.name + ' ' + this.form.worker.surname
                        msg += '<br><br>timbrata uscita alle ore ' + this.formatTime(data.exit_date)
                    }

                    Swal.fire({
                        title: title,
                        icon:'info',
                        html: msg,
                        timer: 10000
                    });

                } else {
                    // errore timbrata
                    Swal.fire({
                        title: 'Errore',
                        icon:'error',
                        html: 'La timbrata non è andata a buon fine a causa del seguente problema:<br><br>' + response.message,
                        timer: 10000
                    });
                }
                this.resetForm()
            }).catch((error) => {
                // API Error
                Swal.fire({
                    title: 'Errore',
                    icon:'error',
                    html: 'Si è verificato un errore.<br>Prego, riprova.',
                    timer: 10000
                });
                this.resetForm()
            })
            // #endregion API Post
        },

        resetForm() {
            this.posting = false
            this.form.worker = ''
            this.form.codice_timbrata = ''
        },
        formatTime(date) {
            // formats date by moment hh:mm:ss
            if (date==null) return ''
            return this.$moment(date).format('HH:mm:ss')
        },
    },
    // #endregion Methods
}
</script>
