<template>
  <div class="box">
    <div class="box-header text-center">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">

          <spinner v-if="!formData.ready"></spinner>
          <div class="row" v-else>

            <h4><span class="glyphicon glyphicon-plus"></span> Asistencia al Curso: {{ formData.data.name }}.</h4>

            <!-- <div class="row">
              <div class="col-xs-6"><p>Profesor: {{ formData.data.teacher }}</p></div>
              <div class="col-xs-6"><p>Submission ID: {{ formData.data.code }}</p></div>
              <div class="col-xs-6"><p>Idioma: {{ formData.data.idioma }}</p></div>
              <div class="col-xs-6" :class="(formData.data.count_class <= 5)?'text-danger':''"><p><b>Clase: {{ formData.data.count_class }}</b></p></div>
            </div> -->

            <!-- <div class="row" v-if="!state.hour">
            <div class="row" v-else>
              <h3 class="text-center">Comienza la clase.</h3>
              <div class="col-md-6">
                <button type="button"
                class="btn btn-success btn-lg"
                :class="{'btn-raised': !cron.start}"
                :disabled="cron.start"
                @click="start">Iniciar Clase</button>
                <button type="button"
                class="btn btn-danger btn-lg"
                :class="{'btn-raised': cron.start}"
                :disabled="!cron.start"
                @click="stop">Finalizar Clase</button>
              </div>
              <div class="col-md-6">
                <div class="reloj" id="Horas">00</div>
                <div class="reloj" id="Minutos">:00</div>
                <div class="reloj" id="Segundos">:00</div>
                <div class="reloj" id="Centesimas">:00</div>
              </div>
            </div> -->

            <div class="row"><pre>{{ formData.data }}</pre></div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.reloj{
  float: left;
  font-size: 60px;
  font-family: Courier,sans-serif;
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
        formData: {
          ready: true,
          data: {}
        }, 
        cron: {
          start: false,
          control: null,
          centesimas: 0,
          segundos: 0,
          minutos: 0,
          horas: 0,
        },
      };
    },
    mounted() {
      this.get();
    },
    methods: {
      get() {
        this.formData.ready = false;
        axios.post('/get-data-assistance', { id: this.$route.params.id })
        .then(response => {
          this.formData.data = response.data.course;
          this.formData.ready = true;
          this.state.hour=true
          // let day_now = moment().day() + 1;
          // if (this.formData.data.days.indexOf(day_now) != -1) {
          //   this.state.text = 'Hoy es la clase.';
          //   this.state.class = 'success';
          //   let now_hour = ((moment().hour() < 10) ? '0' + moment().hour() : moment().hour()) + ':' + ((moment().minutes() < 10) ? '0' + moment().minutes() : moment().minutes());
          //   if (now_hour >= this.formData.data.hour_start && now_hour <= this.formData.data.hour_end) {
          //     if (response.data.course.user_class == null) {
          //       this.state.hour = false;
          //       this.state.text2 = 'En breve Comenzamos...';
          //       setTimeout(() => {this.get();}, 5000);
          //     } else {
          //       this.state.hour = true;
          //       this.state.text2 = '';
          //     }
          //   } else if (now_hour >= this.formData.data.hour_end) {
          //     this.state.text = 'Clase Finalizada.';
          //     this.state.text2 = '';
          //     this.state.class = 'info';
          //   } else {}
          // } else {
          //   this.state.text = 'La clase aún no esta abierta.';
          //   this.state.class = 'danger';
          // }
        });
      },
      stop() {
        // if (!this.cron.start) return;
        // clearInterval(this.cron.control);
        // this.cron.start = false;
      },
      start() {
        if (this.cron.start) return toastr.info('asodjaso');
        // axios.post('/assistance')
        // .then(response => {
          this.cronometro();
          this.cron.start = true;
            // console.log(response.data)
        // });
      },
      cronometro() {
        this.cron.control = setInterval(() => {
          if (this.cron.centesimas < 99) {
            this.cron.centesimas++;
            if (this.cron.centesimas < 10) { this.cron.centesimas = '0' + this.cron.centesimas }
              document.getElementById('Centesimas').innerHTML = ':' + this.cron.centesimas;
          }
          if (this.cron.centesimas == 99) { this.cron.centesimas = -1; }
          if (this.cron.centesimas == 0) {
            this.cron.segundos++;
            if (this.cron.segundos < 10) { this.cron.segundos = '0' + this.cron.segundos }
              document.getElementById('Segundos').innerHTML = ':' + this.cron.segundos;
            if (this.cron.segundos%5 == 0) {console.clear(); };
          }
          if (this.cron.segundos == 59) { this.cron.segundos = -1; }
          if ((this.cron.centesimas == 0) && (this.cron.segundos == 0)) {
            this.cron.minutos++;
            if (this.cron.minutos < 10) { this.cron.minutos = '0' + this.cron.minutos }
              document.getElementById('Minutos').innerHTML = ':' + this.cron.minutos;
          }
          if (this.cron.minutos == 59) { this.cron.minutos = -1; }
          if ( (this.cron.centesimas == 0) && (this.cron.segundos == 0) && (this.cron.minutos == 0) ) {
            this.cron.horas++;
            if (this.cron.horas < 10) { this.cron.horas = '0' + this.cron.horas }
              document.getElementById('Horas').innerHTML = this.cron.horas;
          }
        }, 10);
      }
    }
  }
</script>