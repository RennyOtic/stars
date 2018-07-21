<template>
  <modal id="course_students-form" w="lg">

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

              <div class="col-sm-12">
                <div class="row">
                  <div class="col-md-11">
                    <div class="form-group">
                      <label for="alumn" class="control-label">
                        <span class="fa fa-user"></span> Alumnos:
                      </label>
                      <v-multiselect v-model="student" :options="option_students"></v-multiselect>
                      <small id="alumnHelp" class="form-text text-muted">
                        <span v-text="msg.alumn"></span>
                      </small>
                    </div>
                  </div>
                  <div class="col-sm-1">
                    <button class="btn btn-primary" type="button" style="margin-top: 28px;" data-tool="tooltip" title="Agregar Alumno" @click="add"><i class="fa fa-plus"></i></button>
                  </div>
                </div>
              </div>
              
              <div class="col-md-12">
                <!-- <v-table id="course_students" :columns="tabla.columns" :uri="'/coursestudents?id=' + formData.data.id" @output="id = arguments[0]"></v-table> -->
              </div>
            </div>

          </form>
        </div>
      </div>
    </template>

    <template slot="modal-btn">
      <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
    </template>

  </modal>
</template>

<script>
  import Modal from './../partials/modal.vue';
  import Multiselect from 'vue-multiselect';
  import Tabla from './../partials/table.vue';

  export default {
    name: 'modal-form-course_students',
    components: {
      'modal': Modal,
      'v-multiselect': Multiselect,
      'v-table': Tabla,
    },
    props: ['formData'],
    data () {
      return {
        students: [],
        student: '',
        student_id: '',
        msg: {
          alumn: 'Seleccione el alumno a realizar el curso.',
        },
        tabla: {
          columns: [
          { title: 'Código', field: 'id', sortable: true },
          ]
        }
      };
    },
    watch: {
      student: function () {
        for(let i in this.students) {
          if (this.students[i].fullName == this.student) {
            this.student_id = this.students[i].id;
            return;
          }
        }        
      }
    },
    computed: {
      option_students: function () {
        let options = [];
        for(let i in this.students)
          options.push(this.students[i].fullName);
        return options;
      }
    },
    mounted: function () {
      axios.post('/get-data-course/3')
      .then(response => {
        this.students = response.data;
      })
      .then(response => {
        $('[data-tool="tooltip"]').tooltip();
      });
    },
    methods: {
      add: function (el) {
        $('button[class="btn btn-primary"]').attr('disabled', 'disabled');
        axios.post('/coursestudents', { student_id: this.student_id, course_id: this.formData.data.id })
        .then(response => {
          $('button[class="btn btn-primary"]').removeAttr('disabled');
          toastr.success('Alumno Registrado');
        });
      }
    }
  }
</script>