<template>
  <div class="row">
    <div class="col-md-10 col-md-offset-1" style="margin-top: 50px">
      <form class="" @keyup.enter="registrar">

        <spinner v-if="!formData.ready"></spinner>
        <div class="row" v-else>

          <div class="col-md-6" v-for="input in entries">
            <rs-input :name="input" required="true"
            :readonly="input.readonly"
            v-model="formData.permission[input.id]"
            :msg="msg[input.id]"
            @input="formData.permission[input.id] = arguments[0]"></rs-input>
          </div>

          <div class="col-md-12">
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

  export default {
    name: 'form-permission',
    components: {
      'rs-input': Input
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
            toastr.success('Permiso Actualizado');
            this.$emit('input');
            this.$parent.show = 1;
          });
        }
      }
    }
  }
</script>
