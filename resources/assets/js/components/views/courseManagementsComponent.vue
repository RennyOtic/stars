<template>
    <div class="box">
        <div class="box-header text-center">
            <button type="button"
            class="btn btn-info btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Lista de Cursos"
            @click="show = 1"
            v-if="can('courseManagement.index')"
            v-show="show == 2"><span class="glyphicon glyphicon-list"></span></button>
            <button type="button"
            class="btn btn-success btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Registrar Curso"
            @click="openform('create')"
            v-if="can('courseManagement.store')"
            v-show="show == 1"><span class="glyphicon glyphicon-plus"></span></button>
            <button type="button"
            class="btn btn-info btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Editar Curso"
            @click="openform('edit')"
            v-show="id && show == 1"
            v-if="can('courseManagement.update')"><span class="glyphicon glyphicon-edit"></span></button>
            <button type="button"
            class="btn btn-danger btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Borrar Curso"
            @click="deleted('/courses/'+id, $children[1].get, 'name')"
            v-show="id && show == 1"
            v-if="can('courseManagement.destroy')"><span class="glyphicon glyphicon-trash"></span></button>
            <!-- |  -->
            <!-- <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Ver Alumnos del Curso"
            @click="openform('add')"
            v-show="id"
            v-if="1"><span class="fa fa-users"></span></button> -->
        </div>
        <div class="box-body">
            <!--<rs-form :formData="formData"
            @input="$children[1].get()"
            v-if="can(['rol.store','rol.update'])"
            v-show="show == 2"></rs-form> -->
            <!-- <rs-modal-course_students :formData="formData"
            @input=""
            v-if="1"></rs-modal-course_students> -->
            <rs-form :formData="formData"
            @input="$children[1].get()"
            v-if="can(['courseManagement.store','courseManagement.update'])"
            v-show="show == 2"></rs-form>
            <rs-table :columns="tabla.columns"
            uri="/courses"
            @output="id = arguments[0]"
            v-show="show == 1"></rs-table>
        </div>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';
    import Form from './../forms/Form-course.vue';
    // import Modal2 from './../forms/modal-form-course_students.vue';

    export default {
        name: 'Courses',
        components: {
            'rs-table': Tabla,
            'rs-form': Form,
            // 'rs-modal-course_students': Modal2,
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
                    ]
                }
            };
        },
        methods: {
            openform: function (cond, id = null) {
                this.formData.ready = false;
                this.formData.cond = cond;
                if (cond == 'create') {
                    this.formData.title = ' Registrar Curso.';
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
                    this.formData.ready = true;
                } else if (cond == 'edit' || cond == 'add') {
                    this.formData.url = '/courses/' + this.id;
                    axios.get(this.formData.url)
                    .then(response => {
                        this.formData.ico = 'edit';
                        this.formData.title = 'Editar Curso: ' + response.data.name + '.';
                        if (cond == 'add') {
                            this.formData.ico = 'plus';
                            this.formData.title = 'Estudiantes registrados en: ' + response.data.name + '.';
                        }
                        this.formData.data = response.data;
                        // this.$children[1].$data.teacher = response.data.teacher_
                        this.formData.ready = true;
                    });
                }
                if (cond == 'add') {this.show = 3;
                } else {this.show = 2; }
            }
        }
    }
</script>
