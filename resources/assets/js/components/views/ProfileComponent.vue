<template>
    <div class="row" style="margin-top: 70px">
        <div class="col-md-3">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" :src="user.logoPath" :alt="user.fullName" width="150" style="margin: 0 auto">

                <h3 class="profile-username text-center" v-text="user.fullName"></h3>

                <p class="text-muted text-center" v-for="rol in user.roles">{{ rol.name }}<br></p>
            </div>
        </div>

        <div class="col-md-9">
            <div class="nm">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#settings" data-toggle="tab" aria-expanded="true">
                            <i class="zmdi zmdi-settings"></i> Configuraciones<div class="ripple-container"></div>
                        </a>
                    </li>
                    <li>
                        <a href="#changePass" data-toggle="tab" aria-expanded="true">
                            <i class="glyphicon glyphicon-lock"></i> Cambio de Contraseña<div class="ripple-container"></div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="settings" class="tab-pane active">
                        <form class="form-horizontal" enctype="multipart/form-data" @submit.prevent="updateUser">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Nombres:</label>
                                <div class="col-sm-10">
                                    <input id="name" type="text" class="form-control" placeholder="Nombres" v-model="user.name">
                                    <small id="nameHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="col-sm-2 control-label">Apellidos:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="last_name" placeholder="Apellidos" v-model="user.last_name">
                                    <small id="last_nameHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Correo:</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" placeholder="Correo@dominio.com" v-model="user.email">
                                    <small id="emailHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="num_id" class="col-sm-2 control-label">Cédula:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="num_id" placeholder="Cédula" v-model="user.num_id">
                                    <small id="num_idHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group" v-if="user.module">
                                <label for="module" class="col-sm-2 control-label">Módulo:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="module" placeholder="Módulo" v-model="user.module.module" readonly>
                                </div>
                            </div>
                            <div class="form-group is-empty is-fileinput">
                                <label for="image" class="col-sm-2 control-label">Imagen:</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly="" class="form-control" placeholder="Imagen...">
                                    <input type="file" id="image" class="form-control" name="image" @change="getImage" accept="image/*">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success btn-raised"> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="changePass" class="tab-pane">
                        <form class="form-horizontal" @submit.prevent="changePass">
                            <div class="form-group">
                                <label for="passwordOld" class="col-sm-3 control-label">Contraseña Actual:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="passwordOld" placeholder="********" v-model="pass.passwordOld">
                                    <small id="passwordOldHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">Nueva Contraseña:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" placeholder="********" v-model="pass.password">
                                    <small id="passwordHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="col-sm-3 control-label">Confirmar Contraseña:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password_confirmation" placeholder="********" v-model="pass.password_confirmation">
                                    <small id="password_confirmationHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-success btn-raised"> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
li.active {background-color:#00c3b1;}
</style>

<script>
    export default {
        data() {
            return {
                user: {
                    fullName: '',
                    module: '',
                    image: '',
                },
                pass: {
                    passwordOld: '',
                    password: '',
                    password_confirmation: ''
                }
            }
        },
        created() {
            axios.get('profile')
            .then(response => {
                this.user = response.data;
            });
        },
        methods: {
            getImage(e){
                this.user.image = e.target.files[0];
            },
            changePass() {
                axios.post('change-pass', this.pass)
                .then(response => {
                    this.pass.passwordOld = '';
                    this.pass.password = '';
                    this.pass.password_confirmation = '';
                    toastr.success('Contraseña Actualizada');
                });
            },
            updateUser() {
                var data = new  FormData();
                data.append('image', this.user.image);
                data.append('name', this.user.name);
                data.append('last_name', this.user.last_name);
                data.append('email', this.user.email);
                data.append('num_id', this.user.num_id);


                axios.post('update-user', data)
                .then(response => {
                    toastr.success('Datos Actualizados');
                    window.location.reload();
                });
            }
        }
    }
</script>
