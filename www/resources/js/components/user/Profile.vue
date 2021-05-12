
<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- tab header -->
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Impostazioni</a></li>
                                <li class="nav-item"><a class="nav-link" href="#change-password" data-toggle="tab">Cambio Password</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <!-- Setting Tab -->
                                <div class="tab-pane active show" id="settings">
                                    <form @click.prevent="updateInfo" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Nome</label>

                                            <div class="col-sm-12">
                                            <input type="" v-model="form.name" class="form-control" id="inputName" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                                            <has-error :form="form" field="name"></has-error>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                            <div class="col-sm-12">
                                                <input type="email" v-model="form.email" class="form-control" id="inputEmail" placeholder="Email"  :class="{ 'is-invalid': form.errors.has('email') }">
                                                <has-error :form="form" field="email"></has-error>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success">Aggiorna Profilo</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Setting Tab -->
                                <div class="tab-pane" id="change-password">
                                    <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="current_password" class="col-sm-2 control-label">Password Corrente</label>

                                        <div class="col-sm-12">
                                            <input type="password"
                                                v-model="form.current_password"
                                                class="form-control"
                                                id="current_password"
                                                placeholder="Password corrente"
                                                :class="{ 'is-invalid': form.errors.has('current_password') }"
                                            >
                                            <has-error :form="form" field="current_password"></has-error>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password" class="col-sm-2 control-label">Nuova Password</label>

                                        <div class="col-sm-12">
                                            <input type="password"
                                                v-model="form.new_password"
                                                class="form-control"
                                                id="new_password"
                                                placeholder="Nuova password"
                                                :class="{ 'is-invalid': form.errors.has('new_password') }"
                                            >
                                            <has-error :form="form" field="new_password"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password" class="col-sm-2 control-label">Conferma Password</label>

                                        <div class="col-sm-12">
                                            <input type="password"
                                                v-model="form.confirm_password"
                                                class="form-control"
                                                id="confirm_password"
                                                placeholder="Conferma password"
                                                :class="{ 'is-invalid': form.errors.has('confirm_password') }"
                                            >
                                            <has-error :form="form" field="confirm_password"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                        <button @click.prevent="updatePassword" type="submit" class="btn btn-success">Aggiorna Password</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data(){
            return {
                 form: new Form({
                    id:'',
                    name : '',
                    email: '',
                    password: '',
                    created_at: ''
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            updateInfo(){
                this.$Progress.start();
                if(this.form.password == ''){
                    this.form.password = undefined;
                }
                this.form.put('api/profile')
                .then((data)=>{
                    this.$Progress.finish();
                    Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                })
                .catch((data) => {
                    this.$Progress.fail();

                    Toast.fire({
                        icon: 'error',
                        title: 'Si è verificato un errore! Prego, riprova'
                    });
                });
            },

            updatePassword(){
                this.$Progress.start();
                this.form.post('api/change-password')
                .then((data)=>{
                    //  Fire.$emit('AfterCreate');
                    this.$Progress.finish();
                    this.form.current_password = '';
                    this.form.new_password = '';
                    this.form.confirm_password = '';

                    Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                })
                .catch(() => {
                    this.$Progress.fail();

                    Toast.fire({
                        icon: 'error',
                        title: 'Si è verificato un errore! Prego, riprova'
                    });
                });
            }
        },

        created() {
            this.$Progress.start();
            axios.get("api/profile")
                .then(({ data }) => (this.form.fill(data.data)));
            this.$Progress.finish();
        }
    }
</script>
