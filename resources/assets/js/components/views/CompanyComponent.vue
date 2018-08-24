<template>
    <div class="box">
        <div class="box-header text-center">
            <button type="button"
            class="btn btn-info btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Lista de Empresas"
            @click="show = 1"
            v-if="can('company.index')"
            v-show="show > 1"><span class="glyphicon glyphicon-list"></span></button>
            <button type="button"
            class="btn btn-success btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Registrar Empresas"
            @click="openform('create')"
            v-if="can('company.store')"
            v-show="show == 1"><span class="glyphicon glyphicon-plus"></span></button>
            <button type="button"
            class="btn btn-info btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Editar Empresas"
            @click="openform('edit')"
            v-show="id && show == 1"
            v-if="can('company.update')"><span class="glyphicon glyphicon-edit"></span></button>
            <button type="button"
            class="btn btn-danger btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Borrar Empresas"
            @click="deleted('/company/'+id, $children[0].get, 'name')"
            v-show="id && show == 1"
            v-if="can('company.destroy')"><span class="glyphicon glyphicon-trash"></span></button>
        </div>
        <div class="box-body">
            <rs-table :columns="tabla.columns"
            uri="/company"
            @output="id = arguments[0]"
            v-show="show == 1"></rs-table>
            <rs-form :formData="formData"
            @input="$children[0].get()"
            v-if="can(['company.store','company.update'])"
            v-show="show == 2"></rs-form>
        </div>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';
    import Form from './../forms/Form-company.vue';

    export default {
        name: 'Company',
        components: {
            'rs-table': Tabla,
            'rs-form': Form,
        },
        data() {
            return {
                show: 1,
                id: null,
                formData: {
                    ready: true,
                    title: '',
                    url: '',
                    ico: '',
                    cond: '',
                    data: {}
                },
                tabla: {
                    columns: [
                    { title: 'N°', field: 'id', sortable: true },
                    { title: 'Nombre', field: 'name', sortable: true },
                    { title: 'R.U.T.', field: 'rut', sortable: true },
                    { title: 'Teléfono', field: 'phone', sortable: true },
                    { title: 'Contacto', field: 'name_c', sortable: true },
                    { title: 'Correo', field: 'email_c', sortable: true },
                    ]
                }
            };
        },
        methods: {
            openform: function (cond) {
                this.formData.ready = false;
                this.formData.cond = cond;
                if (this.formData.cond === 'create') {
                    this.formData.title = ' Registrar Empresa.';
                    this.formData.url = '/company';
                    this.formData.ico = 'plus';
                    this.show = 2;
                    this.formData.data = {
                        name: '',
                        rut: '',
                        email: '',
                        phone: '',
                        name_c: '',
                        email_c: '',
                        phone_c: '',
                    };
                    this.formData.ready = true;
                } else {
                    this.formData.url = '/company/' + this.id;
                    axios.get(this.formData.url)
                    .then(response => {
                        this.formData.title = ' Editar Empresa: ' + response.data.name;
                        this.formData.ico = 'plus';
                        this.show = 2;
                        this.formData.data = response.data;
                        this.formData.ready = true;
                    });
                }
            }
        }
    }
</script>
