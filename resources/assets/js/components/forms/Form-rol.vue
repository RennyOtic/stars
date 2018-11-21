<template>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <form class="" @keyup.enter="registrar">

        <spinner v-if="!formData.ready"></spinner>
        <div class="row" v-else>
          <h4><span :class="'glyphicon glyphicon-' + formData.ico"></span> {{ formData.title }}</h4>
          <div class="col-md-6" v-for="input in entries.izq">
            <v-input :name="input" required="true"
            v-model="formData.rol[input.id]"
            :msg="msg[input.id]"
            @input="formData.rol[input.id] = arguments[0]"></v-input>
          </div>

            <div class="col-md-6" v-for="input in entries.der">
              <div class="form-group label-floating clockpicker" :class="!formData.rol[input.id] ? 'is-empty' : ''">
                <label for="special" class="control-label">
                  <span :class="'fa fa-'+input.icon"></span> {{ input.label }}: {{ formData.rol[input.id] }}
                </label>
                <input type="text" class="form-control" :class="input.id" v-model="formData.rol[input.id]" required="required">
                <small :id="input.id+'Help'" class="form-text text-muted">
                  <span v-text="msg[input.id]"></span>
                </small>
              </div>
            </div>

          <div class="col-md-6">
            <div class="form-group rs-select">
              <label for="special" class="control-label">
                <span class="glyphicon glyphicon-calendar"></span> Caracteristica especial:
              </label>
              <select id="special" v-model="formData.rol.special" class="form-control">
                <option value="">Ninguna</option>
                <option value="all-access">Acceso total</option>
                <option value="no-access">Sin acceso</option>
              </select>
              <small id="specialHelp" class="form-text text-muted">
                <span v-text="msg.special"></span>
              </small>
            </div>
          </div>

          <div class="col-xs-12 text-center">
            <v-checkbox-p v-if="!formData.rol.special"
            :user="formData.rol.permissions"
            @check="formData.rol.permissions = arguments[0]"></v-checkbox-p>
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
  import Modal from './../partials/modal.vue';
  import Input from './../partials/input.vue';
  import Checkbox from './../partials/input-checkbox-permissions.vue';

  export default {
    name: 'form-rol',
    components: {
      'modal': Modal,
      'v-input': Input,
      'v-checkbox-p': Checkbox,
    },
    props: ['formData'],
    data () {
      return {
        entries: {
          izq: [
          {label: 'Nombre', id: 'name', icon: 'glyphicon glyphicon-compressed'},
          {label: 'Alias', id: 'slug', icon: 'edit'},
          {label: 'Descripción', id: 'description', icon: 'edit'},
          ],
          der: [
          {label: 'Hora a comenzar la actividad', id: 'from_at', icon: 'calendar'},
          {label: 'Hora a finalizar la actividad', id: 'to_at', icon: 'calendar'},
          ]
        },
        msg: {
          name: 'Nombre del rol.',
          slug: 'Alias del rol.',
          description: 'Descripción del rol.',
          from_at: 'Hora de actividad inicial.',
          to_at: 'Hora de actividad final.',
          special: 'Acceso privilegiado.',
          permission: 'Permisos del rol'
        }
      };
    },
    updated() {
      let vm = this;
      $('.clockpicker').clockpicker({
        autoclose: true,
        default: 'now'
      })
      .find('input').change(function() {
        if ($(this).hasClass('from_at')) {vm.formData.rol.from_at = this.value; }
        else if ($(this).hasClass('to_at')) {vm.formData.rol.to_at = this.value; }
      });
    },
    methods: {
      registrar: function () {
        this.restoreMsg(this.msg);
        if (this.formData.cond === 'create') {
          axios.post(this.formData.url, this.formData.rol)
          .then(response => {
            toastr.success('Rol Registrado');
            this.$emit('input');
            this.$parent.show = 1;
          });
        } else {
          axios.put(this.formData.url, this.formData.rol)
          .then(response => {
            toastr.success('Rol Actualizado');
            this.$emit('input');
            this.$parent.show = 1;
          });
        }
      }
    }
  }
</script>
