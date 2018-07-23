<template>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <form class="" @keyup.enter="registrar">

        <spinner v-if="!formData.ready"></spinner>
        <div class="row" v-else>
          <h4><span :class="'glyphicon glyphicon-' + formData.ico"></span> {{ formData.title }}</h4>

          <div class="col-md-6" v-for="input in entries.uno">
            <rs-input :name="input" required="true"
            v-model="formData.data[input.id]"
            :msg="msg[input.id]"
            @input="formData.data[input.id] = arguments[0]"></rs-input>
          </div>

          <div class="col-md-6">
            <div class="form-group label-floating" :class="!formData.data.teacher_id ? 'is-empty' : ''">
              <label for="teacher_id" class="control-label">
                <span class="fa fa-user"></span> Profesor:
              </label>
              <!-- <v-multiselect v-model="teacher" :options="option_teachers" ></v-multiselect> -->
              <select class="form-control" v-model="formData.data.teacher_id">
                <option value="" selected="" disabled=""></option>
                <option v-for="t in teachers" :value="t.id" v-text="t.fullName"></option>
              </select>
              <small id="teacher_idHelp" class="form-text text-muted">
                <span v-text="msg.teacher_id"></span>
              </small>
            </div>
          </div>

          <!-- <div class="col-md-6">
            <div class="form-group label-floating" :class="!formData.data.type_student_id ? 'is-empty' : ''">
              <label for="type_student_id" class="control-label">
                <span class="fa fa-users"></span> Tipos de estudiantes:
              </label>
              <select class="form-control" v-model="formData.data.type_student_id">
                <option value="" selected="" disabled=""></option>
                <option v-for="t in typestudents" :value="t.id" v-text="t.name"></option>
              </select>
              <small id="type_student_idHelp" class="form-text text-muted">
                <span v-text="msg.type_student_id"></span>
              </small>
            </div>
          </div> -->

          <div class="col-md-6">
            <div class="form-group label-floating" :class="!formData.data.class_type_id ? 'is-empty' : ''">
              <label for="class_type_id" class="control-label">
                <span class="fa fa-users"></span> Tipo de clase:
              </label>
              <select class="form-control" v-model="formData.data.class_type_id">
                <option value="" selected="" disabled=""></option>
                <option v-for="c in classtypes" :value="c.id" v-text="c.name"></option>
              </select>
              <small id="class_type_idHelp" class="form-text text-muted">
                <span v-text="msg.class_type_id"></span>
              </small>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="col-md-6">
                <div class="form-group label-floating" :class="!formData.data.idioma_id ? 'is-empty' : ''">
                  <label for="idioma_id" class="control-label">
                    <span class="fa fa-users"></span> Idioma:
                  </label>
                  <select class="form-control" v-model="formData.data.idioma_id">
                    <option value="" selected="" disabled=""></option>
                    <option v-for="i in idiomas" :value="i.id" v-text="i.name"></option>
                  </select>
                  <small id="idioma_idHelp" class="form-text text-muted">
                    <span v-text="msg.idioma_id"></span>
                  </small>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group label-floating" :class="!formData.data.level_id ? 'is-empty' : ''">
                  <label for="level_id" class="control-label">
                    <span class="fa fa-users"></span> Nivel del Curso:
                  </label>
                  <select class="form-control" v-model="formData.data.level_id">
                    <option value="" selected="" disabled=""></option>
                    <option v-for="l in levels" :value="l.id" v-text="l.name"></option>
                  </select>
                  <small id="level_idHelp" class="form-text text-muted">
                    <span v-text="msg.level_id"></span>
                  </small>
                </div>
              </div>
            </div>
          </div>

          <!-- <date-picker :id="input.id" v-model="formData.data[input.id]" :config="{format: 'HH:mm:ss', useCurrent: true} " required="required"></date-picker> -->
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6" v-for="input in entries.hours">
                <div class="form-group label-floating" :class="!formData.data[input.id] ? 'is-empty' : ''">
                  <label :for="input.id" class="control-label">
                    <span :class="'fa fa-' + input.icon"></span> {{ input.label }}:
                  </label>
                  <input type="text" class="form-control" v-model="formData.data[input.id]">
                  <small :id="input.id+'Help'" class="form-text text-muted">
                    <span v-text="msg[input.id]"></span>
                  </small>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group label-floatng">
              <label for="materials" class="control-label">
                <span class="fa fa-icon"></span> Materiales a usar
              </label>
              <div class="row">
                <div class="col-md-3" v-for="(m, i) in materials">
                  <input type="checkbox" :id="m.name + i" class="" :value="m.id" v-model="formData.data.materials">
                  <label :for="m.name + i" v-text="m.name"></label>
                </div>
              </div>
              <small id="materialsHelp" class="form-text text-muted">
                <span v-text="msg.materials"></span>
              </small>
            </div>
          </div>

          <div class="col-sm-6" v-for="input in entries.dates">
            <rs-input :name="input" required="true"
            :empty="false"
            type="date"
            v-model="formData.data[input.id]"
            :msg="msg[input.id]"
            @input="formData.data[input.id] = arguments[0]"></rs-input>
          </div>

          <div class="col-md-12 text-center">
            <button type="button" class="btn btn-danger" @click="$parent.show = 1"><span class="fa fa-close"></span> Cancelar</button>
            <button type="button" class="btn btn-primary" @click="registrar"><span class="glyphicon glyphicon-saved"></span> Guardar</button>
          </div>

        </div>
      </form>
    </div>
  </div>
</template>

<script>
  import Input from './../partials/input.vue';
  // import Modal from './../partials/modal.vue';
  // import datePicker from 'vue-bootstrap-datetimepicker';
  // import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';
  // import Multiselect from 'vue-multiselect';

  export default {
    name: 'form-course',
    components: {
      'rs-input': Input,
      // 'modal': Modal,
      // datePicker,
      // 'v-multiselect': Multiselect,
    },
    props: ['formData'],
    computed: {
      // option_teachers: function () {
      //   let options = [];
      //   for(let i in this.teachers) options.push(this.teachers[i].fullName);
      //     return options;
      // }
    },
    watch: {
      // teacher: function () {
      //   for(let i in this.teachers) {
      //     if (this.teachers[i].fullName == this.teacher) {
      //       this.formData.data.teacher_id = this.teachers[i].id;
      //       return;
      //     }
      //   }
      // }
    },
    data () {
      return {
        teachers: [],
        typestudents: [],
        idiomas: [],
        classtypes: [],
        levels: [],
        materials: [],
        // teacher: null,
        entries: {
          uno: [
          {label: 'Nombre', id: 'name', icon: 'glyphicon glyphicon-blackboard'},
          {label: 'Submission ID', id: 'code', icon: 'fa fa-qrcode'},
          {label: 'Número de estudiantes', id: 'max_students', icon: 'fa fa-users'},
          {label: 'Número de clases', id: 'max_class', icon: 'fa fa-users'},
          ],
          hours: [
          {label: 'Hora a comenzar', id: 'hour_start', icon: 'hourglass-start'},
          {label: 'Hora a finalizar', id: 'hour_end', icon: 'hourglass-end'},
          ],
          dates: [
          {label: 'Fecha a comenzar', id: 'date_start_at', icon: 'fa fa-calendar-check-o'},
          {label: 'Fecha a finalizar', id: 'date_end_at', icon: 'fa fa-calendar-times-o'},
          {label: 'Fecha a iniciar la inscripción', id: 'date_inscription_start_at', icon: 'fa fa-calendar-minus-o'},
          {label: 'Fecha final de inscripción', id: 'date_inscription_end_at', icon: 'fa fa-calendar-plus-o'},
          ]
        },
        msg: {
          code: 'Código único usado para los cursos.',
          date_end_at: 'Fecha para finalizar el curso.',
          date_inscription_end_at: 'Fecha a finalizar el periodo de inscripción.',
          date_inscription_start_at: 'Fecha a iniciar el periodo de inscripción.',
          date_start_at: 'Fecha para iniciar el curso.',
          hour_end: 'Hora establecida para iniciar el curso.',
          hour_start: 'Hora establecida para terminar el curso.',
          max_students: 'Número maximo de cupos disponibles.',
          name: 'Nombre que se le asignará al curso.',
          teacher_id: 'Profesor a quien se le asignará.',
          max_class: 'Asigne el número maximo de clases que se impartiran.',
          materials: 'Materiales usados para impartir las clases.',
          class_type_id: 'Tipo de asistencia a las clases.',
          idioma_id: 'Idioma a impartir en clase.',
          level_id: 'Nivel del curso.'
        }
      };
    },
    mounted: function () {
      axios.post('/get-data-course')
      .then(response => {
        this.teachers = response.data.teachers;
        this.typestudents = response.data.typestudents;
        this.idiomas = response.data.idiomas;
        this.levels = response.data.levels;
        this.classtypes = response.data.classtypes;
        this.materials = response.data.materials;
      });
    },
    methods: {
      registrar: function (el) {
        el.target.disabled = true;
        this.restoreMsg(this.msg);
        if (this.formData.cond === 'create') {
          axios.post(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Curso Registrado');
            el.target.disabled = false;
            this.$emit('input');
            this.$parent.show = 1;
          });
        } else {
          axios.put(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Curso Actualizado');
            el.target.disabled = false;
            this.$emit('input');
            this.$parent.show = 1;
          });
        }
      }
    }
  }
</script>