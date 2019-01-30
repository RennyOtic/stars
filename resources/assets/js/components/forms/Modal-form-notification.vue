<template>
  <modal id="notification-form" w="md">

    <template slot="modal-title">
      <span :class="'glyphicon glyphicon-' + formData.ico"></span>
      {{ formData.title }}
    </template>

    <template slot="modal-body">
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
          <form class="" @submit.prevent="registrar">
            <div class="">
              <p><b>Motivo de Suspensión/Cancelación:</b> {{ formData.data.motivo }}</p>
              <p><b>Fecha:</b> {{ formData.data.date }}</p>
              <p><b>Observación:</b> {{ formData.data.observation }}</p>
              <div class="form-group rs-select">
                <label for="state" class="control-label">
                  <span class="zmdi zmdi-shield-security zmdi-hc-fw"></span> Seleccione un estado para la notificación:
                </label>
                <select id="state" class="form-control" v-model="formData.data.state">
                  <option :value="null">Seleccione una opción</option>
                  <option value="0">Rechazado</option>
                  <option value="1">Aprobado</option>
                </select>
                <small id="stateHelp" class="form-text text-muted">
                  <span v-text="msg.state"></span>
                </small>
              </div>
              <div class="form-group label-floating" v-show="formData.data.state == 1">
                <label for="date_init" class="control-label">
                  <span class="fa fa-date"></span> Fecha de Reprogramación:
                </label>
                <input type="date" class="form-control" v-model="formData.data.reschedule">
                <small id="rescheduleHelp" class="form-text text-muted">
                  <span v-text="msg.reschedule"></span>
                </small>
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

  export default {
    name: 'modal-form-notification',
    components: {
      'modal': Modal,
    },
    props: ['formData'],
    data () {
      return {
        msg: {
          state: 'Estado de la Notificación',
          reschedule: 'Ingrese la fecha de Reprogramación de la clase'
        }
      }
    },
    methods: {
      registrar: function () {
        this.restoreMsg(this.msg);
        axios.put(this.formData.url, this.formData.data)
        .then(response => {
          $('#notification-form').modal('hide');
          toastr.success('Registro Actualizado');
          this.$emit('input');
        });
      }
    }
  }
</script>