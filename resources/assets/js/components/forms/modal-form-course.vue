<template>
  <modal id="course-form" w="lg">

    <template slot="modal-title">
      <span :class="'glyphicon glyphicon-' + formData.ico"></span>
      {{ formData.title }}
    </template>

    <template slot="modal-body">
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
          <form @keyup.enter="registrar">

            <spinner v-if="!formData.ready"></spinner>
            <div v-else class="row">

              <div class="col-sm-6" v-for="input in entries.uno">
                <v-input :name="input" required="true"
                v-model="formData.data[input.id]"
                :msg="msg[input.id]"
                @input="formData.data[input.id] = arguments[0]"></v-input>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="teacher_id" class="control-label">
                    <span class="fa fa-user"></span> Profesor:
                  </label>
                  <v-multiselect v-model="teacher" :options="option_teachers" ></v-multiselect>
                  <small id="teacher_idHelp" class="form-text text-muted">
                    <span v-text="msg.teacher_id"></span>
                  </small>
                </div>
              </div>

              <div class="col-sm-6" v-for="input in entries.hours">
                <div class="form-group">
                  <label :for="input.id" class="control-label">
                    <span :class="'fa fa-'+input.icon"></span> {{ input.label }}:
                  </label>
                  <date-picker :id="input.id" v-model="formData.data[input.id]" :config="{format: 'HH:mm:ss', useCurrent: true} " required="required"></date-picker>
                  <small :id="input.id+'Help'" class="form-text text-muted">
                    <span v-text="msg[input.id]"></span>
                  </small>
                </div>
              </div>

              <div class="col-sm-6" v-for="input in entries.dates">
                <v-input :name="input" required="true"
                type="date"
                v-model="formData.data[input.id]"
                :msg="msg[input.id]"
                @input="formData.data[input.id] = arguments[0]"></v-input>
              </div>

            </div>

          </form>
        </div>
      </div>
    </template>

    <template slot="modal-btn">
      <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
      <button type="button" class="btn btn-primary" @click="registrar"><span class="glyphicon glyphicon-saved"></span> Guardar</button>
    </template>

  </modal>
</template>

<style>

</style>

<script>
  import Modal from './../partials/modal.vue';
  import Input from './../partials/input.vue';
  import datePicker from 'vue-bootstrap-datetimepicker';
  import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';
  import Multiselect from 'vue-multiselect';

  export default {
    name: 'modal-form-course',
    components: {
      'modal': Modal,
      'v-input': Input,
      datePicker,
      'v-multiselect': Multiselect,
    },
    props: ['formData'],
    computed: {
      option_teachers: function () {
        let options = [];
        for(let i in this.teachers) options.push(this.teachers[i].fullName);
          return options;
      }
    },
    watch: {
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
        teachers: [],
        teacher: null,
        entries: {
          uno: [
          {label: 'Nombre', id: 'name', icon: 'glyphicon glyphicon-blackboard'},
          {label: 'Código', id: 'code', icon: 'fa fa-qrcode'},
          {label: 'Número de estudiantes', id: 'max_students', icon: 'fa fa-users'},
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
          date_inscription_end_at: 'Fecha a finalizar el periodo de inscripción',
          date_inscription_start_at: 'Fecha a iniciar el periodo de inscripción',
          date_start_at: 'Fecha para iniciar el curso.',
          hour_end: 'Hora establecida para iniciar el curso.',
          hour_start: 'Hora establecida para terminar el curso.',
          max_students: 'Número maximo de cupos disponibles.',
          name: 'Nombre que se le asignará al curso.',
          teacher_id: 'Profesor a quien se le asignará.',
        }
      };
    },
    mounted: function () {
      axios.post('/get-data-course/2')
      .then(response => {
        this.teachers = response.data.users_teachers;
      });
    },
    methods: {
      registrar: function (el) {
        $(el.target).attr('disabled', 'disabled');
        this.restoreMsg(this.msg);
        if (this.formData.cond === 'create') {
          axios.post(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Curso Registrado');
            this.$emit('input');
            $('#course-form').modal('hide');
          });
        } else {
          axios.put(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Curso Actualizado');
            this.$emit('input');
            $('#course-form').modal('hide');
          });
        }
      }
    }
  }
</script>