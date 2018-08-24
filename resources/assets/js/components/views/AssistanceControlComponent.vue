<template>
    <div class="box">
        <div class="box-header text-center">
            <router-link :to="{ name: 'assistanceControl.store', params: { id: id } }"
            class="btn btn-success btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Marcar Asistencia"
            @click="openform('create')"
            v-if="can('assistanceControl.store')"
            v-show="id"><span class="glyphicon glyphicon-plus"></span></router-link>
        </div>
        <div class="box-body">
            <rs-table :columns="tabla.columns"
            uri="/assistance"
            @output="id = arguments[0]"></rs-table>
        </div>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';

    export default {
        name: 'AssistanceControl',
        components: {
            'rs-table': Tabla,
        },
        data() {
            return {
                id: null,
                tabla: {
                    columns: [
                    { title: 'Submission ID', field: 'code', sortable: true },
                    { title: 'Nombre del Curso', field: 'name', sortable: true },
                    { title: 'Idioma', field: 'idioma_id', sortable: true },
                    { title: 'Nivel', field: 'level_id', sortable: true },
                    { title: 'Profesor', field: 'teacher_id', sortable: true },
                    { title: 'N° de Clases', field: 'max_class', sortable: true },
                    { title: 'Clases Finalizadas', field: 'user_class' },
                    ]
                }
            };
        }
    }
</script>
