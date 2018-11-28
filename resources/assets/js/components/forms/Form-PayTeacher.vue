<template>
  <div class="box">
    <div class="box-header text-center"></div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">

          <div class="row">
            <div class="col-md-4" v-for="input in entries">
              <rs-input :name="input"
              v-model="data[input.id]"
              type="date"
              @input="data[input.id] = arguments[0]"></rs-input>
            </div>
            <div class="col-md-4">
              <div class="form-group rs-select">
                <label for="teacher_id" class="control-label">
                  <span class="zmdi fa fa-user zmdi-hc-fw"></span> Profesor:
                </label>
                <rs-select :options="teachers" v-model="data.teacher_id"></rs-select>
              </div>
            </div>
            <div class="col-md-3 col-md-offset-4">
              <a href="#" class="btn btn-success btn-lg btn-raised btn-block" @click="generar">Generar</a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Input from './../partials/input.vue';
  import Select2 from './../partials/select2.vue';

  export default {
    name: 'form-PayTeacher',
    components: {
      'rs-input': Input,
      'rs-select': Select2,
    },
    data () {
      return {
        teachers: [],
        data: {
          date_init: '',
          date_end: '',
          teacher_id: ''
        },
        entries: [
        {label: 'Fecha de inicio', id: 'date_init', icon: 'glyphicon glyphicon-calendar'},
        {label: 'Fecha Final', id: 'date_end', icon: 'glyphicon glyphicon-calendar'},
        ],
      }
    },
    mounted() {
      let date = new Date();
      this.data.date_init = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();
      this.data.date_end = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();
      this.get();
    },
    methods: {
      generar() {
        if (this.data.teacher_id == '' || this.data.date_init == '' || this.data.date_end == '') return;
        window.location.href = '/pdf-pay-teacher/' + this.data.teacher_id + '?date_init=' + this.data.date_init + '&date_end=' + this.data.date_end;
      },
      get() {
        axios.post('/get-data-pay-teacher')
        .then(response => {
          this.teachers.push({'id': '', 'text': ''});
          for(let i in response.data.teachers) {
            this.teachers.push(response.data.teachers[i]);
          }
        });
      }
    }
  }
</script>