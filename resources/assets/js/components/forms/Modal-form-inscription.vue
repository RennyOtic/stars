<template>
  <modal id="inscription-form" w="md">

    <template slot="modal-title">
      <span :class="'glyphicon glyphicon-' + formData.ico"></span>
      {{ formData.title }}
    </template>

    <template slot="modal-body">
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
          <form class="" @submit.prevent="registrar">
            <div class="">

              <div class="col-sm-6" v-for="input in entries.izq">
                <rs-input :name="input" required="true"
                :type="input.type"
                v-model="formData.data[input.id]"
                :msg="msg[input.id]"
                @input="formData.data[input.id] = arguments[0]"></rs-input>
              </div>

              <div class="col-md-6" style="height: 102px;">
                <div class="form-group rs-select">
                  <label for="occupation" class="control-label">
                    <span class="zmdi fa fa-id-card-o"></span> Ocupación:
                  </label>
                  <select id="occupation" class="form-control" v-model="formData.data.occupation">
                    <option value="">Ocupación</option>
                    <option v-for="a in activities" v-text="a"></option>
                  </select>
                  <small id="occupationHelp" class="form-text text-muted">
                    <span v-text="msg.occupation"></span>
                  </small>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group rs-select">
                  <label for="nationality_id" class="control-label">
                    <span class="zmdi zmdi-shield-security zmdi-hc-fw"></span> Pais de Origen:
                  </label>
                  <select id="nationality_id" class="form-control" v-model="formData.data.nationality_id">
                    <option value="">Seleccione el Pais de Origen</option>
                    <option v-for="n in nationalities" :value="n.id" v-text="n.name"></option>
                  </select>
                  <small id="nationality_idHelp" class="form-text text-muted">
                    <span v-text="msg.nationality_id"></span>
                  </small>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group rs-select">
                  <label for="how_find" class="control-label">
                    <span class="zmdi zmdi-shield-security zmdi-hc-fw"></span> Cómo se enteró el estudiante de ST:
                  </label>
                  <select id="how_find" class="form-control" v-model="formData.data.how_find">
                    <option value="">Seleccione una opción</option>
                    <option v-for="h in howfinds" :value="h.name" v-text="h.name"></option>
                  </select>
                  <small id="how_findHelp" class="form-text text-muted">
                    <span v-text="msg.how_find"></span>
                  </small>
                </div>
              </div>

              <div class="col-md-12" v-if="formData.data.how_find === 'Otro'">
                <div class="form-group">
                  <label for="how_find_other" class="control-label">
                    <span class="zmdi zmdi-shield-security zmdi-hc-fw"></span> Indique como se enteró:
                  </label>
                  <input type="text" id="how_find_other" class="form-control" v-model="formData.data.how_find_other">
                  <small id="how_find_otherHelp" class="form-text text-muted">
                    <span v-text="msg.how_find_other"></span>
                  </small>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="company_id" class="control-label">
                    <span class="zmdi zmdi-shield-security zmdi-hc-fw"></span> Empresa donde trabaja:
                  </label>
                  <rs-select :options="companies" v-model="formData.data.company_id"></rs-select>
                  <small id="company_idHelp" class="form-text text-muted">
                    <span v-text="msg.company_id"></span>
                  </small>
                </div>
              </div>

            </div>
          </form>
        </div>
      </div>
    </template>

    <template slot="modal-btn">
      <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
      <button type="button" class="btn btn-primary btn-raised" @click="registrar"><span class="glyphicon glyphicon-saved"></span> Guardar</button>
    </template>

  </modal>
</template>

<script>
  import Modal from './../partials/modal.vue';
  import Input from './../partials/input.vue';
  import Select2 from './../partials/select2.vue';

  export default {
    name: 'modal-form-inscription',
    components: {
      'modal': Modal,
      'rs-input': Input,
      'rs-select': Select2,
    },
    props: ['formData', 'course'],
    data () {
      return {
        nationalities: [],
        howfinds: [],
        companies: [],
        activities: [],
        entries: {
          izq: [
          {label: 'Nombre', id: 'name', icon: 'fa fa-user'},
          {label: 'Apellido', id: 'last_name', icon: 'fa fa-user-o'},
          {label: 'RUT', id: 'num_id', icon: 'fa fa-id-card-o'},
          {label: 'Fecha de Nacimiento', id: 'birthday_date', icon: 'fa fa-user-o', type: 'date'},
          // {label: 'Ocupación', id: 'occupation', icon: 'fa fa-id-card-o'},
          {label: 'E-Mail', id: 'email', icon: 'fa fa-envelope'},
          {label: 'Número de Telefono movil', id: 'phone_movil', icon: 'fa fa-user-o'},
          {label: 'Número Telefonico', id: 'phone_home', icon: 'fa fa-user-o'},
          ],
        },
        msg: {
          company_id: 'Empresa asociada al estudiante.',
          name: 'Nombre del usuario.',
          last_name: 'Apellido del usuario.',
          num_id: 'Cedula de identidad.',
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
          how_find: 'Como se enteró de Smooth Talkers.',
          how_find_other: 'Medio por el que se enteró de SM.'
        }
      }
    },
    mounted: function () {
      this.get();
    },
    methods: {
      get() {
        axios.post('/admin/get-data-users')
        .then(response => {
          this.nationalities = response.data.nationalities;
          this.howfinds = response.data.howfinds;
          this.companies = response.data.companies;
          this.activities = response.data.activities;
        });
      },
      registrar: function () {
        this.restoreMsg(this.msg);
        axios.post('/inscriptions', {
          id: this.course,
          student_id: this.formData.data.id,
          birthday_date: this.formData.data.birthday_date,
          email: this.formData.data.email,
          fullName: this.formData.data.fullName,
          how_finds_id: this.formData.data.how_finds_id,
          last_name: this.formData.data.last_name,
          name: this.formData.data.name,
          nationality_id: this.formData.data.nationality_id,
          num_id: this.formData.data.num_id,
          occupation: this.formData.data.occupation,
          phone_home: this.formData.data.phone_home,
          phone_movil: this.formData.data.phone_movil,
          how_find:  this.formData.data.how_find,
          how_find_other:  this.formData.data.how_find_other,
          company_id:  this.formData.data.company_id
        })
        .then(response => {
          toastr.success('Alumno Registrado');
          setTimeout(() => {
            this.$emit('input');
            $('#inscription-form').modal('hide');
          }, 500);
          if (this.formData.data.how_find != '') this.get();
        });
      }
    }
  }
</script>