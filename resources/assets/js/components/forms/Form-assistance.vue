<template>
  <div class="box">
    <div class="box-header text-center">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">

          <spinner v-if="!formData.ready"></spinner>
          <div class="row" v-else>

            <h4><span class="glyphicon glyphicon-plus"></span> Asistencia al Curso:</h4>

            <div class="row">
              <div class="col-xs-4"><p><b>Profesor:</b> {{ formData.data.teacher }}</p></div>
              <div class="col-xs-5"><p><b>Submission ID:</b> {{ formData.data.code }}</p></div>
              <div class="col-xs-3"><p><b>Idioma:</b> {{ formData.data.idioma }}</p></div>
            </div>

            <div class="row" v-if="formData.data.coursestate_id == 2">
              <div class="col-md-6 col-md-offset-3">
                <div class="form-group label-floating">
                  <label for="event" class="control-label">
                    <span class="fa fa-laptop"></span> Acción:
                  </label>
                  <select class="form-control no_ajax" :disabled="cron.start" v-model="event">
                    <option value="1">Comenzar clase</option>
                    <option value="2">Perdir Suspensión / Cancelación</option>
                  </select>
                  <small id="eventHelp" class="form-text text-muted">
                    Selecciona 
                  </small>
                </div>
              </div>
            </div>

            <template v-if="event == 1">
              <div class="row" v-if="formData.data.coursestate_id == 1">
                <h3 class="text-center">Aún no ha comenzado el Curso.</h3>
              </div>
              <div class="row" v-else-if="formData.data.coursestate_id == 2">
                <h3 class="text-center">Comienza la clase.</h3>
                <div class="col-md-6">
                  <button type="button"
                  class="btn btn-success btn-lg no_ajax"
                  :class="{'btn-raised': !cron.start}"
                  :disabled="cron.start === true"
                  @click="start_stop">Iniciar Clase</button>
                  <button type="button"
                  class="btn btn-danger btn-lg no_ajax"
                  :class="{'btn-raised': cron.start}"
                  :disabled="!cron.start"
                  @click="start_stop">Finalizar Clase</button>
                </div>
                <div class="col-md-6">
                  <h2 id='crono' class="reloj">00:00:00:00</h2>
                </div>
              </div>
              <div class="row" v-else>
                <h3 class="text-center">El Curso Ya ha Culminado.</h3>
              </div>
            </template>
            <template v-else>
              <form class="row" @submit.prevent="notify">
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label for="coordinator" class="control-label">
                      <span class="fa fa-user"></span> coordinador:
                    </label>
                    <select class="form-control" v-model="formData.data.coordinator_id" disabled="">
                      <option value="">Seleccione un coordinador</option>
                      <option v-for="c in coordinators" :value="c.id" v-text="c.fullName"></option>
                    </select>
                    <small id="coordinatorHelp" class="form-text text-muted">
                      Selecciona el coordinador para notificarle.
                    </small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label for="motivo" class="control-label">
                      <span class="fa fa-laptop"></span> motivo:
                    </label>
                    <select class="form-control" v-model="formData.data.motivo">
                      <option :value="e.id" v-for="e in event_" v-text="e.name"></option>
                    </select>
                    <small id="motivoHelp" class="form-text text-muted">
                      Seleccione el motivo de Cancelación / Suspensión
                    </small>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group label-floating">
                    <label for="observation" class="control-label">
                      <span class="fa fa-laptop"></span> observación:
                    </label>
                    <textarea id="observation" class="form-control" v-model="formData.data.observation" cols="15" rows="5" style="resize: noen"></textarea>
                    <small id="observationHelp" class="form-text text-muted">
                      Escribe la causa para Cancelación / Suspensión
                    </small>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-5 col-xs-offset-5">
                    <button type="submit" class="btn btn-raised btn-danger">Notificar</button>
                  </div>
                </div>
              </form>
            </template>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
  .reloj {
    float: left;
    font-size: 60px;
    font-family: Courier, "sans-serif";
    color: #363431;
  }
</style>

<script>
  export default {
    name: 'form-assistance',
    components: {},
    data () {
      return {
        state: {},
        coordinators: [],
        event_: [],
        event: 1,
        assistance: '',
        formData: {
          ready: true,
          data: {}
        },
        cron: {
          start: false,
          inicio: 0,
          timeout: 0
        },
      };
    },
    mounted() {
      this.formData.ready = false;
      axios.post('/get-data-assistance', {
        id: this.$route.params.id
      })
      .then(response => {
        if (response.data == '') {
          return this.$router.push({
            name: 'assistanceControl.index'
          });
        }

        this.formData.data = response.data.course;
        this.formData.data.motivo = '';
        this.formData.data.observation = '';
        this.coordinators = response.data.coordinators;
        this.event_ = response.data.eventassistance;
        this.formData.ready = true;

        if (response.data.state) {
          console.log(response.data.state)
          this.cron.start = true;
          this.cron.inicio = response.data.state.time;
          this.assistance = response.data.state.id;
          this.start_cronometro();
          this.hide_show_sidebar();
          toastr.success('La clase aún sigue activa');
        }
      });
    },
    methods: {
      notify() {
        axios.post('/notify', this.formData.data)
        .then(response => {
          toastr.success('Su Solicitud fue procesada con exito. Espere la pronta respuesta de un Coordinador.');
          this.$router.push({name: 'notify_s.index'});
        });
      },
      start_stop() {
        if(this.cron.timeout == 0 && !this.cron.start) {
          axios.post('/assistance', {
            course_id: this.$route.params.id,
            event_id: 1,
            time: new Date().getTime()
          })
          .then(response => {
            this.assistance = response.data.id;
            this.cron.inicio = new Date(response.data.time).getTime();
            this.start_cronometro();
            this.hide_show_sidebar();
            toastr.success('Haz Iniciado tu Clase');
            this.cron.start = true;
            setTimeout(() => {$('select').attr('disabled', 'disabled');}, 500);
          });
        } else if(this.cron.timeout != 0 && this.cron.start) {
          axios.put('/assistance/' + this.assistance, {
            course_id: this.$route.params.id,
            event_id: 3,
          })
          .then(response => {
            clearTimeout(this.cron.timeout);
            this.hide_show_sidebar();
            this.cron.timeout = 0;
            $('select, input').removeAttr('disabled');
            toastr.success('Haz Finalizado tu Clase');
            this.cron.start = false;
          });
        }
      },
      start_cronometro() {
        let interval  = 10;
        // obteneos la fecha actual
        let actual = new Date().getTime();
        // obtenemos la diferencia entre la fecha actual y la de inicio
        let diff = new Date(actual - this.cron.inicio);
        // mostramos la diferencia entre la fecha actual y la inicial
        let result = this.LeadingZero(diff.getUTCHours()) + ':' + this.LeadingZero(diff.getUTCMinutes()) + ':' + this.LeadingZero(diff.getUTCSeconds()) + ':' + this.LeadingZero(diff.getMilliseconds());
        if (diff.getUTCSeconds()%10 == 0 && diff.getMilliseconds() >= 0 && diff.getMilliseconds() <= interval) {
          fetch('/assistance', {
            method: "POST",
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-Token': Laravel.csrfToken,
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              assistance_id: this.assistance,
              event_id: 2
            })
          });
          console.clear();
        }
        if (document.getElementById('crono') !== null) {
          document.getElementById('crono').innerHTML = result.substr(0, 11);
        }
        // Indicamos que se ejecute esta función nuevamente dentro de 1 segundo
        this.cron.timeout = setTimeout(() => { this.start_cronometro(); }, interval);
      },
      /* Funcion que pone un 0 delante de un valor si es necesario */
      LeadingZero(Time) { return (Time < 10) ? "0" + Time : + Time; },
      hide_show_sidebar() {
        let body = $('.dashboard-contentPage');
        let sidebar = $('.dashboard-sideBar');
        if(sidebar.css('pointer-events') == 'none'){
          $('.btn-menu-dashboard').show();
          body.removeClass('no-paddin-left');
          sidebar.removeClass('hide-sidebar').addClass('show-sidebar');
        } else {
          $('.btn-menu-dashboard').hide();
          body.addClass('no-paddin-left');
          sidebar.addClass('hide-sidebar').removeClass('show-sidebar');
        }
      },
    }
  }
</script>