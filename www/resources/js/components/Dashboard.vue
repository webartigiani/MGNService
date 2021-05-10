<template>
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <!-- timbrate recenti -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Timbrate Recenti</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>Dipendente</th>
                                        <th>Data/Ora</th>
                                        <th>Timbrata</th>
                                        <th>Veicolo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                        <td>07/05/2021 08:01:59</td>
                                        <td><span class="badge badge-success">Entrata</span></td>
                                        <td>senza</td>
                                    </tr>
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                        <td>07/05/2021 07:57:03</td>
                                        <td><span class="badge badge-success">Entrata</span></td>
                                        <td>41.1369472,16.8132608</td>
                                    </tr>
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                        <td>07/05/2021 07:55:43</td>
                                        <td><span class="badge badge-success">Entrata</span></td>
                                        <td>41.1369472,16.8132608</td>
                                    </tr>
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                        <td>07/05/2021 07:30:12</td>
                                        <td><span class="badge badge-success">Entrata</span></td>
                                        <td>non rilevata</td>
                                    </tr>
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                        <td>06/05/2021 19:02:31</td>
                                        <td><span class="badge badge-warning">Uscita</span></td>
                                        <td>41.1369472,16.8132608</td>
                                    </tr>
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                        <td>06/05/2021 18:59:03</td>
                                        <td><span class="badge badge-warning">Uscita</span></td>
                                        <td>41.1369472,16.8132608</td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- dipendenti presenti -->
                    <div class="info-box mb-3 bg-success">
                        <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Presenti</span>
                            <span class="info-box-number">13/25</span>
                        </div>
                    </div>

                    <!-- dipendenti assenti -->
                    <div class="info-box mb-3 bg-warning">
                        <span class="info-box-icon"><i class="far fa-tired"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Assenti</span>
                            <span class="info-box-number">12</span>
                        </div>
                    </div>

                    <!-- veicoli in uso -->
                    <div class="info-box mb-3 bg-info">
                        <span class="info-box-icon"><i class="fas fa-car"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Veicoli in uso</span>
                            <span class="info-box-number">2/2</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>


export default {
  name: "Example",
  data() {
    return {
    }
  },
  methods: {
  }
}
</script>
