<template>
  <div>
    <v-modal id="permission-form">

      <h4 class="card-title" slot="modal-title">
        <span class="glyphicon glyphicon-edit"></span>
        {{ formData.title }}
      </h4>

      <template slot="modal-body">
        <div class="row justify-content-center">
          <div class="col-md-10 col-md-offset-1">
            <form id="PermissionsForm" @keyup.enter="registrar">

              <spinner v-if="!formData.ready"></spinner>
              <div v-else>
                <template v-for="input in entries">
                  <v-input :name="input" required="true"
                          :readonly="input.readonly"
                          v-model="formData.permission[input.id]"
                          :msg="msg[input.id]"
                          @input="formData.permission[input.id] = arguments[0]">
                  </v-input>
                </template>

                <div class="form-group">
                  <label for="deleted_at" class="control-label">
                    <span class="glyphicon glyphicon-inbox"></span> Activo:
                  </label>
                  <select id="deleted_at" required="true" class="form-control" v-model="formData.permission.deleted_at">
                    <option :value="false">Activo</option>
                    <option :value="true">Inactivo</option>
                  </select>
                  <small id="deleted_atHelp" class="form-text text-muted">
                    <span v-text="msg.deleted_at"></span>
                  </small>
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

    </v-modal>
  </div>
</template>

<script>
  import Modal from './../partials/modal.vue';
  import Input from './../partials/input.vue';

  export default {
    name: 'modal-form-permission',
    components: {
      'v-modal': Modal,
      'v-input': Input
    },
    props: ['formData'],
    data () {
      return {
        msg: {
          name: 'Nombre del Permiso.',
          module: 'Modulo a ejecutarse.',
          action: 'Acción a Realizar.',
          description: 'Descripción a realizar.',
          deleted_at: 'Activar o Inactivar permiso.'
        },
        entries: [
          {label: 'Módulo', id: 'module', icon: 'edit', readonly: true},
          {label: 'Acción', id: 'action', icon: 'edit', readonly: true},
          {label: 'Nombre', id: 'name', icon: 'edit'},
          {label: 'Descripción', id: 'description', icon: 'edit'},
        ]
      };
    },
    methods: {
      registrar: function () {
        this.restoreMsg(this.msg);
        if (this.formData.cond === 'edit') {
          axios.put(this.formData.url, this.formData.permission)
          .then(response => {
            toastr.success('Permiso Editado');
            $('#permission-form').modal('toggle');
            this.$emit('input');
          });
        }
      }
    }
  }
</script>
