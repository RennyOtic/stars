<template>
  <select class="form-control">
    <slot></slot>
  </select>
</template>

<style>
select{width: 100%; color: red;}
</style>

<script>
  export default {
    props: ['options', 'value'],
    mounted () {
      var vm = this
      $(this.$el)
      // init select2
      .select2({ data: this.options })
      .val(this.value)
      .trigger('change')
      // emit event on change.
      .on('change', function () {
        vm.$emit('input', this.value)
      });
      setTimeout(() => {
        let element = $(this.$el).parent()[0].children[2];
        $(element).addClass('form-control');
      }, 500);
    },
    watch: {
      value: function (value) {
        // update value
        $(this.$el).val(value).trigger('change');
      },
      options: function (options) {
        // update options
        $(this.$el).empty().trigger('change').select2({ data: options })
      }
    },
    destroyed: function () {
      $(this.$el).off().select2('destroy')
    }
  }
</script>
