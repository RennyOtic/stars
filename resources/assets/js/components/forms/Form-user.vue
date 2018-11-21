<template>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <form class="" @keyup.enter="registrar">

        <spinner v-if="!formData.ready"></spinner>
        <div class="row" v-else>
          <h4><span :class="'glyphicon glyphicon-' + formData.ico"></span> {{ formData.title }}</h4>

          <div class="col-sm-6" v-for="input in entries.izq">
            <rs-input :name="input" required="true"
            :type="input.type"
            v-model="formData.user[input.id]"
            :msg="msg[input.id]"
            @input="formData.user[input.id] = arguments[0]"></rs-input>
          </div>

          <div class="col-sm-6">
            <div class="form-group label-floating">
              <label for="birthday_date" class="control-label">
                <span class="fa fa-user-o"></span> Fecha de cumpleaños:
              </label>
              <input id="birthday_date" type="date" class="form-control">
              <small id="birthday_dateHelp" class="form-text text-muted" v-text="msg.birthday_date"></small>
            </div>
          </div>

          <div class="col-sm-6" v-for="input in entries.der">
            <rs-input :name="input" required="true"
            :type="input.type"
            v-model="formData.user[input.id]"
            :msg="msg[input.id]"
            @input="formData.user[input.id] = arguments[0]"></rs-input>
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
    name: 'form-user',
    components: {
      'rs-input': Input,
      'rs-select': Select2,
    },
    props: ['formData'],
    data () {
      return {
        entries: {
          izq: [
          {label: 'Nombre', id: 'name', icon: 'fa fa-user'},
          {label: 'Apellido', id: 'last_name', icon: 'fa fa-user-o'},
          {label: 'RUT', id: 'num_id', icon: 'fa fa-id-card-o'},
          {label: 'Número de Telefono movil', id: 'phone_movil', icon: 'fa fa-user-o'},
          {label: 'Ocupación', id: 'occupation', icon: 'fa fa-id-card-o'},
          {label: 'Número Telefonico', id: 'phone_home', icon: 'fa fa-user-o'},
          {label: 'E-Mail', id: 'email', icon: 'fa fa-envelope'},
          ],
          der: [
          {label: 'Contraseña', id: 'password', icon: 'fa fa-lock', type: 'password'},
          {label: 'Confirmación de Contraseña', id: 'password_confirmation', icon: 'fa fa-lock', type: 'password'},
          ],
        },
        roles: [],
        nationalities: [],
        companies: [],
        msg: {
          name: 'Nombre del usuario.',
          last_name: 'Apellido del usuario.',
          num_id: 'RUT/Pasaporte.',
          email: 'Correo electronico.',
          password: 'Contraseña.',
          password_confirmation: 'Confirmación de Contraseña.',
          roles: 'Perfil a desempeñar.',
          position: 'Cargo que desempeña.',
          occupation: 'Ocupación actual del usuario.',
          phone_home: 'Telefono de habitación o trabajo.',
          phone_movil: 'Número personal.',
          birthday_date: 'Fecha de cumpleaños.',
          nationality_id: 'Nacionalidad natural.',
          company_id: 'Empresa afiliada el usario.'
        }
      };
    },
    mounted: function () {
      axios.post('/admin/get-data-users')
      .then(response => {
        this.roles = response.data.roles;
        this.nationalities = response.data.nationalities;
        this.companies = response.data.companies;
      });
    },
    methods: {
      registrar: function (el) {
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