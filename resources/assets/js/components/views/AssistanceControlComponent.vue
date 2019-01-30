<template>
    <div class="box">
        <div class="box-header text-center">
            <!-- <router-link class="btn btn-success btn-raised btn-xs"
            :to="{ name: 'assistanceControl.store', params: { id: id } }"
            data-tooltip="tooltip"
            title="Marcar Asistencia"
            v-if="can('assistanceControl.store')"
            v-show="id"
            ><span class="glyphicon glyphicon-plus"></span></router-link> -->
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
                id: 0,
                tabla: {
                    columns: [
                    { title: 'Submission ID', field: 'code', sortable: true },
                    { title: 'Idioma', field: 'idioma_id', sortable: true },
                    { title: 'Nivel', field: 'level_id', sortable: true },
                    { title: 'Profesor', field: 'teacher_id', sortable: true },
                    { title: 'Estado', field: 'coursestate_id', sortable: true },
                    ]
                }
            };
        },
        watch: {
            id: function (val) {
                if (this.can('assistanceControl.store')) {
                    if (val)
                        this.$router.push({ name: 'assistanceControl.store', params: { id: val } });
                }
            }
        }
    }
</script>
