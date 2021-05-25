<!--
    accesso_dipendenti
-->
<template>
    <div>
        <form @submit.prevent="editmode ? updateItem() : createItem()">
            <!--
            <div class="modal-header">
                <h5 class="modal-title">Timbra Presenza</h5>
            </div>
            -->
            <div class="modal-body">
                <div class="form-group">
                    <select
                        name="worker"
                        v-model="form.worker"
                        class="form-control"
                        >
                        <option value="">&lt;seleziona&gt;</option>
                        <option v-for="item in workers" :value="item" :key="item.id">
                        {{ item.nome }} {{ item.cognome }}
                        </option>
                    </select>
                    <has-error :form="form" field="nome"></has-error>
                </div>
                <div class="form-group">
                <input v-model="form.codice_timbrata" type="text" name="codice_timbrata"
                    placeholder="Codice Timbrata"
                    class="form-control upper"
                    :maxlength="10"
                    >
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-lg">Timbra</button>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>

<script>
export default {
    components: {
    },

    // #region Properties
    data() {
        return {
            workers: [],
            form: {
                worker: '',
                codice_timbrata: ''
            }
        }
    },
    // #endregion Properties

    // #region Component Life Cycle
    beforeCreate() {
    },
    created() {
        // lists workers
        axios.get("api/worker").then(({ data }) => (
            this.workers = data.data
        ));
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

    // #region Methods

    // #endregion Methods
}
</script>
