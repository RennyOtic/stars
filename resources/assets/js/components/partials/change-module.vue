<template>
  <li class="nav-item dropdown messages-menu">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      {{ module_current.module }}
      <span class="caret" v-if="modules"></span>
    </a>
    <ul class="dropdown-menu d" aria-labelledby="navbarDropdown" v-if="modules">
      <li v-for="(module, key) in modules"
        class="dropdown-item menu"
        @click.prevent="change(key)"><a href="#">{{ module }}</a></li>
    </ul>
  </li>
</template>

<style>
  .dropdown-menu.d {max-width: 180px; }
</style>

<script>
  export default {
    name: 'dropdown-change-module',
    data () {
      return {
        module_current: [],
        modules: []
      };
    },
    mounted: function () {
      axios.get('/admin/change-module-user')
      .then(response => {
        this.module_current = response.data.module;
        this.modules = response.data.modules;
      });
    },
    methods: {
      change: function (key) {
        axios.post('/admin/change-module-user', {key})
        .then(response => {
          toastr.success('Modulo cambiado.');
          setTimeout(function () {location.reload();}, 1000);
        });
      }
    }
  }
</script>