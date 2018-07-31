<template>
    <div class="box">
        <div class="box-header text-center">
            <!-- <button type="button"
            class="btn btn-info btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Lista de Cursos"
            @click="show = 1"
            v-if="can('assistanceControl.index')"
            v-show="show > 1"><span class="glyphicon glyphicon-list"></span></button> -->
            <!-- <button type="button"
            class="btn btn-success btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Marcar Asistencia"
            @click="openform('create')"
            v-if="can('assistanceControl.store') || 1"
            v-show="id && show == 1"><span class="glyphicon glyphicon-plus"></span></button> -->
            <!-- <button type="button"
            class="btn btn-info btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Editar Curso"
            @click="openform('edit')"
            v-show="id && show == 1"
            v-if="can('assistanceControl.update')"><span class="glyphicon glyphicon-edit"></span></button> -->
            <!-- <button type="button"
            class="btn btn-danger btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Borrar Curso"
            @click="deleted('/courses/'+id, $children[2].get, 'name')"
            v-show="id && show == 1"
            v-if="can('courseManagement.destroy')"><span class="glyphicon glyphicon-trash"></span></button> -->
            <!-- <span v-show="id && show == 1">|</span> -->
            <!-- <button type="button"
            class="btn btn-success btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Lista de Alumnos Inscritos"
            @click="openform('add')"
            v-show="id && show == 1"
            v-if="can('inscription.index')"><span class="fa fa-list"></span></button> -->
        </div>
        <div class="box-body">
            <!-- <rs-list-students :formData="formData"
            @input="$children[2].get()"
            v-if="can() || 1"
            v-show="show == 3"></rs-list-students> -->
            <!-- <rs-form :formData="formData"
            @input="$children[2].get()"
            v-if="can(['courseManagement.store','courseManagement.update'])"
            v-show="show == 2"></rs-form> -->
            <rs-table :columns="tabla.columns"
            uri="/assistance"
            @output="id = arguments[0]"
            v-show="show == 1"></rs-table>
        </div>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';
    // import Form from './../forms/Form-course.vue';
    // import Form2 from './../forms/Form-course-students.vue';

    export default {
        name: 'AssistanceControl',
        components: {
            'rs-table': Tabla,
            // 'rs-form': Form,
            // 'rs-list-students': Form2,
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
                    { title: 'Submission ID', field: 'code', sortable: true },
                    { title: 'Nombre del Curso', field: 'name', sortable: true },
                    { title: 'Idioma', field: 'idioma_id', sortable: true },
                    { title: 'Nivel', field: 'level_id', sortable: true },
                    { title: 'Profesor', field: 'teacher_id', sortable: true },
                    { title: 'N° de Clases', field: 'max_class', sortable: true },
                    { title: 'Clases Finalizadas', field: 'user_class', sortable: true },
                    ]
                }
            };
        },
        methods: {
            openform: function (cond) {
                this.formData.ready = false;
                this.formData.cond = cond;
                if (cond == 'create') {
                    /*this.formData.title = ' Registrar Curso.';
                    this.formData.url = '/courses';
                    this.formData.ico = 'plus';
                    this.formData.data = {
                        name: '',
                        code: '',
                        hour_start: '',
                        hour_end: '',
                        idioma_id: '',
                        teacher_id: '',
                        max_students: '',
                        max_class: '',
                        // type_student_id: '',
                        level_id: '',
                        class_type_id: '',
                        date_start_at: '',
                        date_end_at: '',
                        date_inscription_start_at: '',
                        date_inscription_end_at: '',
                        materials: [],
                    };
                    this.formData.ready = true;*/
                } else if (cond == 'edit' || cond == 'add') {
                    /*this.formData.url = '/courses/' + this.id;
                    axios.get(this.formData.url)
                    .then(response => {
                        this.formData.ico = 'edit';
                        this.formData.title = 'Editar Curso: ' + response.data.name + '.';
                        if (cond == 'add') {
                            this.formData.ico = 'plus';
                            this.formData.title = 'Curso: ' + response.data.code + '.';
                        }
                        this.formData.data = response.data;
                        this.formData.ready = true;
                    });*/
                }
                if (cond == 'add') {this.show = 3;
                } else {this.show = 2; }
            }
        }
    }
</script>
