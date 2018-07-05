<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-users"></i> Tabla de Usuarios:</h3>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Registrar Usuario"
            @click="openform('create')"
            v-if="can('user.store')"><span class="glyphicon glyphicon-plus"></span></button>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Editar Usuario"
            @click="openform('edit')"
            v-show="user"
            v-if="can('user.update')"><span class="glyphicon glyphicon-edit"></span></button>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Borrar Usuario"
            @click="deleted('/admin/users/'+user, $children[0].get, 'fullName')"
            v-show="user"
            v-if="can('user.destroy')"><span class="glyphicon glyphicon-trash"></span></button>
            <v-modal-form :formData="formData" @input="$children[0].get()" v-if="can(['user.store','user.update'])"></v-modal-form>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <v-table id="users" :columns="tabla.columns" uri="/admin/users" @output="user = arguments[0]"></v-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Modal from './../forms/modal-form-user.vue';
    import Tabla from './../partials/table.vue';

    export default {
        name: 'Users',
        components: {
            'v-modal-form': Modal,
            'v-table': Tabla,
        },
        data() {
            return {
                user: null,
                formData: {
                    ready: true,
                    title: '',
                    url: '',
                    ico: '',
                    cond: '',
                    user: {}
                },
                tabla: {
                    columns: [
                    { title: 'Nombre y Apellido', field: 'fullName', sort: 'name', sortable: true },
                    { title: 'Cargo', field: 'position', sortable: true },
                    { title: 'Cédula', field: 'num_id', sortable: true },
                    { title: 'Correo', field: 'email', sortable: true },
                    { title: 'Rol', field: 'rol' },
                    ]
                }
            };
        },
        methods: {
            openform: function (cond, user = null) {
                this.formData.ready = false;
                if (cond == 'create') {
                    this.formData.title = ' Registrar Usuario.';
                    this.formData.url = '/admin/users';
                    this.formData.ico = 'plus';
                    this.formData.user = {
                        email: '',
                        last_name: '',
                        name: '',
                        num_id: '',
                        password: '',
                        password_confirmation: '',
                        position: '',
                        roles: [],
                    };
                    this.formData.ready = true;
                } else if (cond == 'edit') {
                    this.formData.url = '/admin/users/' + this.user;
                    axios.get(this.formData.url)
                    .then(response => {
                        this.formData.ico = 'edit';
                        this.formData.title = 'Editar Usuario: ' + response.data.fullName + '.';
                        this.formData.user = response.data;

                        let roles = response.data.roles;
                        let options = [];
                        for (let rol in roles){
                            options.push(roles[rol].name);
                        }
                        this.formData.user.roles = options;

                        this.formData.ready = true;
                    });
                }
                $('#user-form').modal('show');
                this.formData.cond = cond;
            }
        }
    }
</script>
