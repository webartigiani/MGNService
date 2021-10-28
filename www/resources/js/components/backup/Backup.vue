<template>
  <section class="content">
    <div class="container-fluid">

        <h3 class="mb-4">Backup</h3>

        <div v-if="!loadingData && items.length === 0">
            Nessun Backup disponibile
        </div>

        <div class="card backup"
            v-for="(item, index) in items"
            :key="index"
            @click.prevent="download(item)"
        >
            <div class="card-body">
                <h6 class="card-subtitle mb-3 text-muted"><i class="fa fa-database"></i></h6>
                <span class="text-muted">{{ item.filename }}</span>
                <br><br>
                <p class="card-text small text-muted">
                    created on {{ item.date }} {{ item.time }}<br>
                    size: {{ Math.round((item.size / 1024 / 1024) * 100) / 100 }} MB
                </p>
                <a href="#"
                    class="card-link"
                >download</a>
            </div>
        </div>
    </div>
  </section>
</template>

<style scoped>
a.action {
    margin-right:5px!important;
}

div.card.backup {
    width:      230px;
    height:     190px;
    margin:     10px;
    padding:    2px;
    display:    inline-block;
    flex-direction:unset;
    cursor: pointer;
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
            loadingData: true,
            items : [],
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
        list() {
            this.$Progress.start()
            this.loadingData = true
            axios.get("api/backup").then(({ data }) => {
                this.items = data
                this.$Progress.finish()
                this.loadingData = false
            });
        },
        download(dump) {
            // Downloads a dump file
            window.open('download-dump/?f=' + dump.filename, '_blank');
        }
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
