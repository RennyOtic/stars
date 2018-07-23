<template>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <form class="" @keyup.enter="registrar">

        <spinner v-if="!formData.ready"></spinner>
        <div class="row" v-else>
          <h4><span :class="'glyphicon glyphicon-' + formData.ico"></span> {{ formData.title }}</h4>
          <div class="col-sm-6">
            <template v-for="input in entries.izq">
              <rs-input :name="input" required="true"
              :type="input.type"
              v-model="formData.user[input.id]"
              :msg="msg[input.id]"
              @input="formData.user[input.id] = arguments[0]"></rs-input>
            </template>
          </div>

          <div class="col-sm-6">
            <template v-for="input in entries.der">
              <rs-input :name="input" required="true"
              v-model="formData.user[input.id]"
              :msg="msg[input.id]"
              @input="formData.user[input.id] = arguments[0]"></rs-input>
            </template>

            <div class="form-group rs-select">
              <label for="roles" class="control-label">
                <span class="zmdi zmdi-shield-security zmdi-hc-fw"></span> Perfil:
              </label>
              <select id="roles" class="form-control" v-model="formData.user.roles">
                <option :value="[]">Seleccione un rol</option>
                <option v-for="(r, i) in roles" :value="i" v-text="r"></option>
              </select>
              <small id="rolesHelp" class="form-text text-muted">
                <span v-text="msg.roles"></span>
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
    name: 'form-user',
    components: {
      'rs-input': Input,
    },
    props: ['formData'],
    data () {
      return {
        entries: {
          izq: [
          {label: 'Nombre', id: 'name', icon: 'fa fa-user'},
          {label: 'RUT', id: 'num_id', icon: 'fa fa-id-card-o'},
          {label: 'Contraseña', id: 'password', icon: 'fa fa-lock', type: 'password'},
          {label: 'Confirmación de Contraseña', id: 'password_confirmation', icon: 'fa fa-lock', type: 'password'},
          ],
          der: [
          {label: 'Apellido', id: 'last_name', icon: 'fa fa-user-o'},
          {label: 'E-Mail', id: 'email', icon: 'fa fa-envelope'},
          ],
        },
        roles: [],
        msg: {
          name: 'Nombre del usuario.',
          last_name: 'Apellido del usuario.',
          num_id: 'Cedula de identidad.',
          email: 'Correo electronico.',
          password: 'Contraseña.',
          password_confirmation: 'Confirmación de Contraseña.',
          roles: 'Rol a desempeñar.',
          position: 'Cargo que desempeña.'
        }
      };
    },
    mounted: function () {
      axios.post('/admin/get-data-users')
      .then(response => {
        this.roles = response.data.roles;
      });
    },
    methods: {
      registrar: function (el) {
        $(el.target).attr('disabled', 'disabled');
        this.restoreMsg(this.msg);
        if (this.formData.cond === 'create') {
          axios.post(this.formData.url, this.formData.user)
          .then(response => {
            toastr.success('Usuario Registrado');
            this.$emit('input');
            this.$parent.show = 1;
          });
        } else {
          axios.put(this.formData.url, this.formData.user)
          .then(response => {
            toastr.success('Usuario Actualizado');
            this.$emit('input');
            this.$parent.show = 1;
          });
        }
      }
    }
  }
</script>