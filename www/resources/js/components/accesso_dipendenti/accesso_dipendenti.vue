<!--
    accesso_dipendenti
-->
<template>
    <div>
        <form @submit.prevent="timbra()">
            <!--
            <div class="modal-header">
                <h5 class="modal-title">Timbra Presenza</h5>
            </div>
            -->
            <input type="hidden" name="source" v-model="form.source" />

            <div class="modal-body">
                <div class="form-group">
                    <select
                        name="worker"
                        v-model="form.worker"
                        class="form-control"
                        >
                        <option value="">&lt;seleziona&gt;</option>
                        <option v-for="item in workers" :value="item" :key="item.id">
                        {{ item.name }} {{ item.surname }}
                        </option>
                    </select>
                    <has-error :form="form" field="worker"></has-error>
                </div>
                <div class="form-group">
                <input v-model="form.codice_timbrata" type="text" name="codice_timbrata"
                    placeholder="Codice Timbrata"
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
export default {
    components: {
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
            console.log(this.form.worker)
            console.log(this.form.codice_timbrata)

            this.posting = true

            this.form.post('api/attendance').then((result) => {
                console.log(result)
                this.posting = false
                Toast.fire({
                    icon: 'info',
                    html: 'Bravo!'
                });
            }).catch(() => {
                Toast.fire({
                    icon: 'info',
                    title: 'Si è verificato un errore<br>Prego, riprova'
                });
                this.posting = false
            })
        }
    }
    // #endregion Methods
}
</script>
