<template>
  <modal id="rol-form" w="lg">

    <template slot="modal-title">
      <span :class="'glyphicon glyphicon-'+formData.ico"></span>
      {{ formData.title }}
    </template>

    <template slot="modal-body">
      <div class="row">
        <form id="roles-form" class="" @keyup.enter="registrar()">
          <div class="col-md-10 col-md-offset-1">

            <spinner v-if="!formData.ready"></spinner>
            <div v-else>
              <div class="col-md-6">
                <template v-for="input in entries.izq">
                  <v-input :name="input" required="true"
                  v-model="formData.rol[input.id]"
                  :msg="msg[input.id]"
                  @input="formData.rol[input.id] = arguments[0]">
                </v-input>
              </template>
            </div>

            <div class="col-md-6">
              <div class="form-group" v-for="input in entries.der">
                <label for="special" class="control-label">
                  <span :class="'fa fa-'+input.icon"></span> {{ input.label }}:
                </label>
                <date-picker id="" v-model="formData.rol[input.id]" :config="{format: 'HH:mm:ss', useCurrent: false} " required="required"></date-picker>
                <small :id="input.id+'Help'" class="form-text text-muted">
                  <span v-text="msg[input.id]"></span>
                </small>
              </div>
              
              <div class="form-group">
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

            <v-checkbox-p v-if="!formData.rol.special"
            :user="formData.rol.permissions"
            @check="formData.rol.permissions = arguments[0]"
            ></v-checkbox-p>

          </div>
        </div>
      </form>
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
  import Input from './../partials/input.vue';
  import datePicker from 'vue-bootstrap-datetimepicker';
  import Checkbox from './../partials/input-checkbox-permissions.vue';
  import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';
  
  export default {
    name: 'modal-form-rol',
    components: {
      'modal': Modal,
      'v-input': Input,
      'v-checkbox-p': Checkbox,
      datePicker
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
    methods: {
      registrar: function () {
        this.restoreMsg(this.msg);
        if (this.formData.cond === 'create') {
          axios.post(this.formData.url, this.formData.rol)
          .then(response => {
            toastr.success('Rol Creado Exitosamente');
            this.$emit('input');
            $('#rol-form').modal('toggle');
          });
        } else {
          axios.put(this.formData.url, this.formData.rol)
          .then(response => {
            toastr.success('Rol Editado Exitosamente');
            this.$emit('input');
            $('#rol-form').modal('toggle');
          });
        }
      }
    }
  }
</script>
