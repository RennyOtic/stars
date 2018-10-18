<template>
    <div class="box">
        <div class="box-header text-center">
            <a class="btn btn-success btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Editar"
            v-if="can('notify_s.update')"
            v-show="id"
            @click="openform('edit')"><span class="glyphicon glyphicon-edit"></span></a>
            <button type="button"
            class="btn btn-danger btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Borrar"
            @click="deleted('/notify/'+id, $children[0].get, 'motivo')"
            v-show="id"
            v-if="can('notify_s.destroy')"><span class="glyphicon glyphicon-trash"></span></button>
        </div>
        <div class="box-body">
            <rs-table :columns="tabla.columns"
            uri="/notify"
            :sh_s="false"
            @output="id = arguments[0]"></rs-table>
        </div>
        <rs-modal :formData="formData" @input="$children[0].get('this')"></rs-modal>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';
    import Modal from './../forms/Modal-form-notification.vue';

    export default {
        name: 'Notification',
        components: {
            'rs-table': Tabla,
            'rs-modal': Modal,
        },
        data() {
            return {
                id: 0,
                formData: {
                    ready: false,
                    ico: '',
                    cond: '',
                    title: '',
                    data: {},
                },
                tabla: {
                    columns: [
                    { title: 'Curso', field: 'course' },
                    { title: 'Profesor', field: 'teacher' },
                    { title: 'Estudiante', field: 'student' },
                    { title: 'Coordinador', field: 'coordinator_id', sortable: true },
                    { title: 'Estado', field: 'state', sortable: true },
                    { title: 'Motivo', field: 'motivo' },
                    { title: 'Fecha', field: 'date', sort: 'created_at', sortable: true },
                    ]
                }
            };
        },
        methods: {
            openform: function (cond) {
                this.formData.ready = false;
                this.formData.ico = cond;
                this.formData.cond = cond;
                $('#notification-form').modal('show');
                if (cond === 'create') {} else {
                    this.formData.url = '/notify/' + this.id;
                    axios.get(this.formData.url)
                    .then(response => {
                        this.formData.title = 'Editar Notificación de: ' + response.data.student;
                        this.formData.data = response.data;
                        this.formData.ready = true;
                    });
                }
            }
        }
    }
</script>
