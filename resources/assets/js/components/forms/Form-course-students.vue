<template>
  <div class="box">
    <div class="box-header"></div>
    <div class="box-body" style="margin-top: 45px">
      <h3 class=" text-center">
        <span class="glyphicon glyphicon-users"></span> {{ all.title }}
      </h3>

      <div class="row text-center">
        <div class="col-xs-6"><p>Profesor: {{ all.teacher }}</p></div>
        <div class="col-xs-6"><p>Idioma: {{ all.idioma }}</p></div>
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
          @click="show"><i class="fa fa-plus"></i></button>
        </div>
      </div>

      <div class="col-md-12">
        <div class="row text-center" v-if="can('inscription.destroy')">
          <button class="btn btn-danger btn-raised btn-xs"
          type="button"
          data-tooltip="tooltip"
          title="Borrar Alumno"
          @click="remove"
          v-show="id"
          v-if="can('inscription.destroy')"><i class="fa fa-minus"></i></button>
          <a :href="'/pdf-inscription/' + all.id + '/' + id" 
          class="btn btn-info btn-raised btn-xs"
          data-tooltip="tooltip"
          title="Inscripción del Curso"
          v-show="id"
          v-if="can('report.inscription')"><i class="glyphicon glyphicon-save"></i></a>
          <a :href="'/pdf-assistance/' + all.id + '/' + id" 
          class="btn btn-warning btn-raised btn-xs"
          data-tooltip="tooltip"
          title="Asistencia al Curso"
          v-show="id"
          v-if="can('report.assistance')"><i class="glyphicon glyphicon-save"></i></a>
        </div>
        <rs-table id="course_students"
        :columns="tabla.columns"
        uri="/inscriptions"
        @output="id = arguments[0]"
        :data="all.id"
        v-if="all.id"></rs-table>
      </div>
      <rs-modal :formData="formData"
      :course="all.id"
      @input="get"></rs-modal>
    </div>
  </div>
</template>

<script>
  import Tabla from './../partials/table.vue';
  import Select2 from './../partials/select2.vue';
  import Modal from './Modal-form-inscription.vue';

  export default {
    name: 'form-students-list',
    components: {
      'rs-table': Tabla,
      'rs-select': Select2,
      'rs-modal': Modal,
    },
    data () {
      return {
        id: 0,
        all: [],
        students: [],
        student_id: null,
        formData: {
          data: {}
        },
        msg: {
          student_id: 'Seleccione el alumno a realizar el curso.'
        },
        tabla: {
          columns: [
          { title: 'Nombre', field: 'fullName', sort: 'name', sortable: true },
          { title: 'RUT', field: 'num_id', sortable: true },
          ]
        }
      };
    },
    updated() {
      $('[data-tooltip="tooltip"]').tooltip();
    },
    mounted() {
      axios.post('/get-data-inscription')
      .then(response => this.students = response.data.students);
      axios.get('/courses/' + this.$route.params.id)
      .then(response => {
        this.all = response.data;
        this.all.title = 'Inscripción en el curso: ' + response.data.code + '.';
      });
    },
    methods: {
      get: function () {
        this.$children[2].get();
        this.student_id = null;
      },
      show: function () {
        if (!this.student_id) return toastr.info('Seleccione un estudiante.');
        axios.get('/admin/users/' + this.student_id)
        .then(response => {
          this.formData.ico = 'plus';
          this.formData.title = 'Registrar Alumno: ' + response.data.fullName + '.';
          this.formData.data = response.data;
          $('#inscription-form').modal('show');
        });
      },
      remove: function () {
        if (this.id == '') return toastr.info('Seleccione un estudiante.');
        axios.delete('/inscriptions/' + this.formData.data.id + '?id=' + this.id)
        .then(response => {
          toastr.success('Alumno Borrado');
          this.$children[2].get();
        });
      }
    }
  }
</script>