<template>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <form class="" @submit.prevent="registrar" @keyup.enter="registrar">

        <spinner v-if="!formData.ready"></spinner>
        <div class="row" v-else>
          <h4><span :class="'glyphicon glyphicon-' + formData.ico"></span> {{ formData.title }}</h4>

          <div class="col-md-6" v-for="input in entries.uno">
            <rs-input :name="input" required="true"
            :readonly="input.readonly"
            v-model="formData.data[input.id]"
            :msg="msg[input.id]"
            @input="formData.data[input.id] = arguments[0]"></rs-input>
          </div>

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

          <div class="col-md-6">
            <div class="form-group label-floating">
              <label for="teacher_id" class="control-label">
                <span class="fa fa-user"></span> Profesor:
              </label>
              <rs-select :options="teachers" v-model="formData.data.teacher_id"></rs-select>
              <small id="teacher_idHelp" class="form-text text-muted">
                <span v-text="msg.teacher_id"></span>
              </small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group label-floating">
              <label for="coordinator_id" class="control-label">
                <span class="fa fa-user"></span> Coordinador:
              </label>
              <rs-select :options="coordinators" v-model="formData.data.coordinator_id"></rs-select>
              <small id="coordinator_idHelp" class="form-text text-muted">
                <span v-text="msg.coordinator_id"></span>
              </small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group label-floating" :class="!formData.data.company_id ? 'is-empty' : ''">
              <label for="company_id" class="control-label">
                <span class="fa fa-users"></span> Empresa:
              </label>
              <rs-select :options="companies" v-model="formData.data.company_id"></rs-select>
              <small id="company_idHelp" class="form-text text-muted">
                <span v-text="msg.company_id"></span>
              </small>
            </div>
          </div>

          <div class="col-md-6">
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
          </div>

          <div class="col-md-6">
            <div class="form-group label-floating" :class="!formData.data.coursestate_id ? 'is-empty' : ''">
              <label for="coursestate_id" class="control-label">
                <span class="fa fa-users"></span> Estado del curso:
              </label>
              <select class="form-control" v-model="formData.data.coursestate_id">
                <option value="" selected="" disabled=""></option>
                <option v-for="c in coursestates" :value="c.id" v-text="c.name"></option>
              </select>
              <small id="coursestate_idHelp" class="form-text text-muted">
                <span v-text="msg.coursestate_id"></span>
              </small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group label-floating">
              <label for="date_init" class="control-label">
                <span class="fa fa-users"></span> Fecha de inicio:
              </label>
              <input type="date" class="form-control" v-model="formData.data.date_init">
              <small id="date_initHelp" class="form-text text-muted">
                <span v-text="msg.date_init"></span>
              </small>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group label-floatng">
              <label for="material_id" class="control-label">
                <span class="fa fa-icon"></span> Materiales a usar
              </label>
              <div class="row">
                <div class="col-md-3" v-for="(m, i) in materials">
                  <input type="radio" :id="m.name + i" class="" :value="m.id" v-model="formData.data.material_id">
                  <label :for="m.name + i" v-text="m.name"></label>
                </div>
              </div>
              <small id="material_idHelp" class="form-text text-muted">
                <span v-text="msg.material_id"></span>
              </small>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label for="days" class="control-label">
                <span class="fa fa-icon"></span> Dias a realizar el curso:
              </label>
              <div class="row">
                <div class="col-md-3" v-for="(d, i) in days">
                  <input type="checkbox" :id="d.name + i" class="" :value="d.id" v-model="days_selected">
                  <label :for="d.name + i" v-text="d.name"></label>
                </div>
              </div>
              <small id="daysHelp" class="form-text text-muted">
                <span v-text="msg.days"></span>
              </small>
            </div>
          </div>

          <div class="col-md-12" v-for="d in formData.data.days">
            <p>
              <span class="fa fa-icon"></span> Horario del día {{ days[d.day_id - 1].name }}:
            </p>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group" style="margin: -25px 0 0 0;">
                  <label class="control-label">
                    <span class="fa fa-hourglass-start"></span> Hora a comenzar:
                  </label>
                  <input type="text" class="form-control" v-model="d.hour_start" placeholder="Ejem: 00:00">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group" style="margin: -25px 0 0 0;">
                  <label class="control-label">
                    <span class="fa fa-hourglass-end"></span> Hora a finalizar:
                  </label>
                  <input type="text" class="form-control" v-model="d.hour_end" placeholder="Ejem: 23:59">
                </div>
              </div>
            </div>
            <small class="form-text text-muted">
              Horas asignadas para este día.
            </small>
          </div>

          <div class="col-md-12 text-center">
            <button type="button" class="btn btn-danger" @click="$parent.show = 1"><span class="fa fa-close"></span> Cancelar</button>
            <button type="button" class="btn btn-primary btn-raised" @click="registrar"><span class="glyphicon glyphicon-saved"></span> Guardar</button>
          </div>

        </div>
      </form>
    </div>
  </div>
</template>

<script>
  import Input from './../partials/input.vue';
  import Select2 from './../partials/select2.vue';

  export default {
    name: 'form-course',
    components: {
      'rs-input': Input,
      'rs-select': Select2,
    },
    props: ['formData'],
    watch: {
      days_selected: function (val) {
        let days = this.formData.data.days;
        let test = false;
        let old = {};
        let arr = [];
        for(let i in val) {
          for(let a in days) {
            if (days[a].day_id == val[i]) {
              old = {
                id: (days[a].id) ? days[a].id : null,
                hour_start: days[a].hour_start,
                hour_end: days[a].hour_end,
                day_id: val[i],
              };
            }
          }
          if (old.day_id) {
            arr.push(old);
          } else {
            arr.push({
              hour_start: '',
              hour_end: '',
              day_id: val[i],
            });
          }
          old = {};
        }
        for(let i in days) {
          test = false;
          for(let a in arr) {
            if (days[i].day_id == arr.day_id) {
              test = true;
            }
          }
          if (!test) {continue;}
          arr.push(days[i]);
        }
        this.formData.data.days = arr;
      },
      teacher: function () {
        for(let i in this.teachers) {
          if (this.teachers[i].fullName == this.teacher) {
            this.formData.data.teacher_id = this.teachers[i].id;
            return;
          }
        }
      }
    },
    data () {
      return {
        coordinators: [],
        companies: [],
        coursestates: [],
        teachers: [],
        typestudents: [],
        idiomas: [],
        classtypes: [],
        levels: [],
        materials: [],
        days: [],
        days_selected: [],
        teacher: null,
        entries: {
          uno: [
          {label: 'Submission ID', id: 'code', icon: 'fa fa-qrcode'},
          ],
        },
        msg: {
          class_type_id: 'Tipo de asistencia a las clases.',
          code: 'Código único usado para los cursos.',
          date_init: 'Fecha de inicio del curso',
          coordinator_id: 'Coordinador asignado al curso.',
          company_id: 'Empresa que contrató el servicio.',
          idioma_id: 'Idioma a impartir en clase.',
          material_id: 'Materiales usados para impartir las clases.',
          teacher_id: 'Profesor a quien se le asignará.',
          type_student_id: 'Tipo de estudiantes que haran el curso.',
          level_id: 'Nivel del curso.',
          days: 'Dias en la semana que se ejecutara el curso.'
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
        this.days = response.data.days;
        this.coordinators = response.data.coordinators;
        this.companies = response.data.companies;
        this.coursestates = response.data.coursestates;
      });
    },
    methods: {
      registrar: function (el) {
        this.restoreMsg(this.msg);
        if (this.formData.cond === 'create') {
          axios.post(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Curso Registrado');
            this.$emit('input');
            this.$parent.show = 1;
          });
        } else {
          axios.put(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Curso Actualizado');
            this.$emit('input');
            this.$parent.show = 1;
          });
        }
      }
    }
  }
</script>