<template>
    <div class="box">
        <div class="box-header text-center">
            <button type="button"
            class="btn btn-info btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Lista de Usuarios"
            @click="show = 1"
            v-if="can('user.index')"
            v-show="show == 2"><span class="glyphicon glyphicon-list"></span></button>
            <button type="button"
            class="btn btn-success btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Registrar Usuario"
            @click="openform('create')"
            v-if="can('user.store')"
            v-show="show == 1"><span class="glyphicon glyphicon-plus"></span></button>
            <button type="button"
            class="btn btn-info btn-raised btn-xs" 
            data-tooltip="tooltip"
            title="Editar Usuario"
            @click="openform('edit')"
            v-show="id && show == 1"
            v-if="can('user.update')"><span class="glyphicon glyphicon-edit"></span></button>
            <button type="button"
            class="btn btn-danger btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Inactivar Usuario"
            @click="deleted('/admin/users/'+id, $children[1].get, 'fullName')"
            v-show="id && show == 1 && !data.state"
            v-if="can('user.destroy')"><span class="glyphicon glyphicon-trash"></span></button>
            <button type="button"
            class="btn btn-primary btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Activar Usuario"
            @click="restore(id)"
            v-show="id && show == 1 && data.state"
            v-if="can('user.restore')"><span class="glyphicon glyphicon-saved"></span></button>
            <a :href="'/pdf-course-inscription/' + id"
            class="btn btn-default btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Cursos Inscritos"
            v-show="show == 1 && id && is(id, 'Alumno')"
            v-if="can('report.course_inscription')"><span class="glyphicon glyphicon-save"></span></a>
            <a :href="'/pdf-course-teacher/' + id"
            class="btn btn-default btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Cursos por Profesor"
            v-show="show == 1 && id && is(id, 'Profesor')"
            v-if="can('report.course_teacher')"><span class="glyphicon glyphicon-save"></span></a>
            <a :href="'/logging/'+id"
            v-if="can('user.sesion_stars')"
            v-show="id && show == 1"
            type="button"
            class="btn btn-raised bg-maroon btn-xs"
            style="z-index: 100">login</a>
        </div>
        <div class="box-body">
            <rs-form :formData="formData"
            @input="$children[1].get()"
            v-if="can(['user.store','user.update'])"
            v-show="show == 2"></rs-form>
            <rs-table :columns="tabla.columns"
            uri="/admin/users"
            @output="id = arguments[0]"
            @outputData="data = arguments[0]"
            v-show="show == 1"></rs-table>
        </div>
    </div>
</template>

<script>
    import Modal from './../forms/Form-user.vue';
    import Tabla from './../partials/table.vue';

    export default {
        name: 'Users',
        components: {
            'rs-form': Modal,
            'rs-table': Tabla,
        },
        data() {
            return {
                show: 1,
                id: null,
                data: {},
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
                    { title: 'RUT / Pasaporte', field: 'num_id', sortable: true },
                    { title: 'Correo', field: 'email', sortable: true },
                    { title: 'Perfil', field: 'rol' },
                    { title: 'Estado', field: 'state_text', sortable: true },
                    ]
                }
            };
        },
        methods: {
            is(id, rol) {
                let d = this.$children[1].rows;
                for(let i in d) {
                    if (d[i].id == id) {
                        if (d[i].rol.indexOf(rol) != -1) {
                            return true;
                        }
                        continue;
                    }
                }
                return false;
            },
            openform: function (cond) {
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
                        birthday_date: '',
                        nationality_id: '',
                        occupation: '',
                        phone_home: '',
                        type: '',
                        phone_movil: '',
                        company_id: '',
                    };
                    this.formData.ready = true;
                } else if (cond == 'edit') {
                    this.formData.url = '/admin/users/' + this.id;
                    axios.get(this.formData.url)
                    .then(response => {
                        this.formData.ico = 'edit';
                        this.formData.title = 'Editar Usuario: ' + response.data.fullName + '.';
                        this.formData.user = response.data;
                        this.formData.user.roles = response.data.roles[0].id;
                        this.formData.ready = true;
                    });
                }
                this.show = 2;
                this.formData.cond = cond;
            },
            restore: function (id) {
                axios.post('/admin/users/' + id + '/restore')
                .then(response => {this.$children[1].get();});
            }
        }
    }
</script>
