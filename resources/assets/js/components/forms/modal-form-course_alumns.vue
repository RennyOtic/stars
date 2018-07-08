<template>
  <modal id="course_alumns-form" w="lg">

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
                      <v-multiselect v-model="alumn" :options="option_alumns" ></v-multiselect>
                      <small id="alumnHelp" class="form-text text-muted">
                        <span v-text="msg.alumn"></span>
                      </small>
                    </div>
                  </div>
                  <div class="col-sm-1">
                    <button class="btn btn-primary" type="button" style="margin-top: 28px;" data-tool="tooltip" title="Agregar Alumno"><i class="fa fa-plus"></i></button>
                  </div>
                </div>
              </div>
              
              <div class="col-md-12">
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

<script>
  import Modal from './../partials/modal.vue';
  import Multiselect from 'vue-multiselect';

  export default {
    name: 'modal-form-course_alumns',
    components: {
      'modal': Modal,
      'v-multiselect': Multiselect,
    },
    props: ['formData'],
    data () {
      return {
        alumns: [],
        alumn: null,
        msg: {
          alumn: 'Seleccione el alumno a realizar el curso.',
        },
        tabla: {
          columns: [
          { title: 'Código', field: 'code', sortable: true },
          ]
        }
      };
    },
    computed: {
      option_alumns: function () {
        let options = [];
        for(let i in this.alumns)
          options.push(this.alumns[i].fullName);
        return options;
        $('[data-tool="tooltip"]').tooltip();
      }
    },
    mounted: function () {
      axios.post('/get-data-course/3')
      .then(response => {
        this.alumns = response.data;
      });
    },
    methods: {
      registrar: function (el) {
        $(el.target).attr('disabled', 'disabled');
        if (this.formData.cond === 'create') {
          axios.post(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Alumno Registrado');
          });
        }
      }
    }
  }
</script>