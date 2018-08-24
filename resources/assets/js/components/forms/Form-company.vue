<template>
  <div class="row">
    <div class="col-md-10 col-md-offset-1" style="margin-top: 50px">
      <form class="" @keyup.enter="registrar">

        <spinner v-if="!formData.ready"></spinner>
        <div class="row" v-else>

          <div class="col-md-6" v-for="input in entries">
            <rs-input :name="input" required="true"
            :type="input.type"
            :readonly="input.readonly"
            v-model="formData.data[input.id]"
            :msg="msg[input.id]"
            @input="formData.data[input.id] = arguments[0]"></rs-input>
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

  export default {
    name: 'form-company',
    components: {
      'rs-input': Input
    },
    props: ['formData'],
    data () {
      return {
        msg: {
          name: 'Nombre de la empresa.',
          rut: 'RUT de la Empresa',
          email: 'Correo principal de la empresa',
          phone: 'Teléfono de la empresa',
          name_c: 'Nombre del solicitante del servicio',
          email_c: 'Correo del solicitante del servicio',
          phone_c: 'Teléfono del solicitante del servicio',
        },
        entries: [
        {label: 'Nombre', id: 'name', icon: 'edit'},
        {label: 'RUT', id: 'rut', icon: 'edit'},
        {label: 'Correo Institucional', id: 'email', icon: 'edit', type: 'email'},
        {label: 'Teléfono Institucional', id: 'phone', icon: 'edit'},
        {label: 'Nombre del contratante', id: 'name_c', icon: 'edit'},
        {label: 'Correo del contratante', id: 'email_c', icon: 'edit', type: 'email'},
        {label: 'Teléfono del contratante', id: 'phone_c', icon: 'edit'},
        ]
      };
    },
    methods: {
      registrar: function (el) {
        this.restoreMsg(this.msg);
        if (this.formData.cond === 'create') {
          axios.post(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Empresa Registrada');
            this.$emit('input');
            this.$parent.show = 1;
          });
        } else {
          axios.put(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Empresa Actualizada');
            this.$emit('input');
            this.$parent.show = 1;
          });
        }
      }
    }
  }
</script>
