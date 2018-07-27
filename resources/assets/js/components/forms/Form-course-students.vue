<template>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">

      <spinner v-if="!formData.ready"></spinner>
      <div class="row" v-else>

        <h4><span :class="'glyphicon glyphicon-' + formData.ico"></span> {{ formData.title }}</h4>

        <div class="row">
          <div class="col-xs-6"><p>Curso: {{ formData.data.name }}</p></div>
          <div class="col-xs-6"><p>Profesor: {{ formData.data.teacher }}</p></div>
          <div class="col-xs-6"><p>Idioma: {{ formData.data.idioma }}</p></div>
          <div class="col-xs-6" :class="(formData.data.cupos <= 5)?'text-danger':''"><p><b>Cupos: {{ formData.data.cupos }}</b></p></div>
        </div>

        <div class="row" v-if="can('inscription.store')">
          <div class="col-xs-7 col-xs-offset-2">
            <div class="form-group">
              <label for="student_id" class="control-label">
                <span class="fa fa-user"></span> Alumnos:
              </label>
              <rs-select :options="students" v-model="student_id"></rs-select>
              <small id="student_idHelp" class="form-text text-muted">
                <span v-text="msg.student_id"></span>
              </small>
            </div>
          </div>
          <div class="col-xs-1">
            <button class="btn btn-primary btn-raised"
            type="button"
            style="margin-top: 60px;"
            data-tooltip="tooltip"
            title="Agregar Alumno"
            @click="add"><i class="fa fa-plus"></i></button>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row text-center" v-if="can('inscription.destroy')">
            <button class="btn btn-danger btn-raised btn-xs"
            type="button"
            data-tooltip="tooltip"
            title="Borrar Alumno"
            @click="remove"
            v-if="id"><i class="fa fa-minus"></i></button>
          </div>
          <v-table id="course_students"
          :columns="tabla.columns"
          :uri="'/inscriptions'"
          @output="id = arguments[0]"
          :data="formData.data.id"
          v-if="formData.data.id"></v-table>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
  import Tabla from './../partials/table.vue';
  import Select2 from './../partials/select2.vue';

  export default {
    name: 'form-students-list',
    components: {
      'rs-select': Select2,
      'v-table': Tabla,
    },
    props: ['formData'],
    data () {
      return {
        id: 0,
        students: [],
        student_id: '',
        students_incription: [],
        msg: {student_id: 'Seleccione el alumno a realizar el curso.'},
        tabla: {
          columns: [
          { title: 'Nombre', field: 'fullName', sort: 'name', sortable: true },
          { title: 'RUT', field: 'num_id', sortable: true },
          ]
        }
      };
    },
    updated() {$('[data-tooltip="tooltip"]').tooltip();},
    mounted() {
      axios.post('/get-data-inscription')
      .then(response => {
        this.students = response.data.students;
      });
    },
    methods: {
      add() {
        if (this.formData.data.cupos == 0) return toastr.info('Curso lleno.');
        axios.post('/inscriptions', {
          id: this.formData.data.id,
          student_id: this.student_id
        })
        .then(response => {
          toastr.success('Alumno Registrado');
          --this.formData.data.cupos;
          this.$children[1].get();
        });
        this.student_id = null;
      },
      remove() {
        if (this.formData.data.cupos == this.formData.data.max_students) return toastr.info('Curso Vacio.');
        axios.delete('/inscriptions/' + this.formData.data.id + '?id=' + this.id)
        .then(response => {
          toastr.success('Alumno Borrado');
          ++this.formData.data.cupos;
          this.$children[1].get();
        });
      }
    }
  }
</script>