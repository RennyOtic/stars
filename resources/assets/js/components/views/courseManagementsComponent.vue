<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><i class="glyphicon glyphicon-blackboard"></i> Tabla de Cursos:</h3>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Registrar Curso"
            @click="openform('create')"
            v-if="can('courseManagement.store')"><span class="glyphicon glyphicon-plus"></span></button>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Editar Curso"
            @click="openform('edit')"
            v-show="id"
            v-if="can('courseManagement.update')"><span class="glyphicon glyphicon-edit"></span></button>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Borrar Curso"
            @click="deleted('/courses/'+id, $children[1].get, 'name')"
            v-show="id"
            v-if="can('courseManagement.destroy')"><span class="glyphicon glyphicon-trash"></span></button> | 
            <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Ver Alumnos del Curso"
            @click="openform('add')"
            v-show="id"
            v-if="1"><span class="fa fa-users"></span></button>
            <v-modal-form :formData="formData" @input="$children[1].get()" v-if="can(['courseManagement.store','courseManagement.update'])"></v-modal-form>
            <v-modal-course_students :formData="formData" @input="" v-if="1"></v-modal-course_students>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <v-table id="courses" :columns="tabla.columns" uri="/courses" @output="id = arguments[0]"></v-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Modal from './../forms/modal-form-course.vue';
    import Tabla from './../partials/table.vue';
    import Modal2 from './../forms/modal-form-course_students.vue';

    export default {
        name: 'Courses',
        components: {
            'v-modal-form': Modal,
            'v-table': Tabla,
            'v-modal-course_students': Modal2,
        },
        data() {
            return {
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
                    { title: 'Código', field: 'code', sortable: true },
                    { title: 'Nombre del Curso', field: 'name', sortable: true },
                    { title: 'Profesor', field: 'teacher_id', sortable: true },
                    ]
                }
            };
        },
        methods: {
            openform: function (cond, id = null) {
                this.formData.ready = false;
                if (cond == 'create') {
                    this.formData.title = ' Registrar Curso.';
                    this.formData.url = '/courses';
                    this.formData.ico = 'plus';
                    this.formData.data = {
                        code: '',
                        date_end_at: '',
                        date_inscription_end_at: '',
                        date_inscription_start_at: '',
                        date_start_at: '',
                        hour_end: '',
                        hour_start: '',
                        max_students: '',
                        name: '',
                        teacher_id: '',
                        teacher: '',
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
                        this.$children[1].$data.teacher = response.data.teacher_
                        this.formData.ready = true;
                    });
                }
                this.formData.cond = cond;
                if (cond == 'add') {
                    $('#course_students-form').modal('show');
                    return;
                }
                $('#course-form').modal('show');
            }
        }
    }
</script>
