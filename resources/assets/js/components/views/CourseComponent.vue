<template>
    <div class="box">
        <div class="box-header text-center">
            <button type="button"
            class="btn btn-info btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Lista de Cursos"
            @click="show = 1"
            v-if="can('courseManagement.index')"
            v-show="show > 1"><span class="glyphicon glyphicon-list"></span></button>
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
            @click="deleted('/courses/'+id, $children[2].get, 'code')"
            v-show="id && show == 1"
            v-if="can('courseManagement.destroy')"><span class="glyphicon glyphicon-trash"></span></button>
            <span v-show="id && show == 1">|</span>
            <router-link :to="{ name: 'inscription.index', params: { id: id } }"
            class="btn btn-success btn-raised btn-xs"
            data-tooltip="tooltip"
            title="Lista de Alumnos Inscritos"
            v-show="show == 1"
            v-if="can('inscription.index') && id"><span class="glyphicon glyphicon-plus"></span></router-link>
        </div>
        <div class="box-body">
            <rs-table :columns="tabla.columns"
            uri="/courses"
            @output="id = arguments[0]"
            v-show="show == 1"></rs-table>
            <rs-form :formData="formData"
            @input="$children[0].get()"
            v-if="can(['courseManagement.store','courseManagement.update'])"
            v-show="show == 2"></rs-form>
        </div>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';
    import Form from './../forms/Form-course.vue';

    export default {
        name: 'Courses',
        components: {
            'rs-table': Tabla,
            'rs-form': Form,
        },
        update() {
            $('[data-tooltip="tooltip"]').tooltip();
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
                    { title: 'Idioma', field: 'idioma_id', sortable: true },
                    { title: 'Nivel', field: 'level_id', sortable: true },
                    { title: 'Profesor', field: 'teacher_id', sortable: true },
                    { title: 'Inscritos', field: 'cupos' },
                    ]
                }
            };
        },
        methods: {
            openform: function (cond) {
                this.formData.ready = false;
                this.formData.cond = cond;
                if (cond == 'create') {
                    this.formData.title = ' Registrar Curso.';
                    this.formData.url = '/courses';
                    this.formData.ico = 'plus';
                    this.$children[1].days_selected = [];
                    this.formData.data = {
                        name: '',
                        code: '',
                        coordinator_id: '',
                        hour_start: '',
                        hour_end: '',
                        idioma_id: '',
                        teacher_id: '',
                        max_students: '',
                        max_class: '',
                        type_student_id: '',
                        level_id: '',
                        class_type_id: '',
                        date_start_at: '',
                        date_end_at: '',
                        date_inscription_start_at: '',
                        date_inscription_end_at: '',
                        material_id: '',
                        days: []
                    };
                    this.formData.ready = true;
                } else if (cond == 'edit') {
                    this.formData.ico = cond;
                    this.formData.url = '/courses/' + this.id;
                    axios.get(this.formData.url)
                    .then(response => {
                        this.formData.title = 'Editar Curso: ' + response.data.code + '.';
                        this.formData.data = response.data;

                        let days = response.data.days;
                        let arr = [];
                        for(let i in days) {
                            arr.push({
                                id: days[i].day_id,
                                name: days[i].name
                            });
                        }
                        this.$children[1].days_selected = arr;
                        this.formData.ready = true;
                    });
                }
                this.show = 2;
            }
        }
    }
</script>
