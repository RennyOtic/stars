<template>
    <div class="row">
        <div class="col-sm-1 pull-left">
            <select class="form-control" v-model="num">
                <option v-for="i in n" :value="i" v-text="i"></option>
            </select>
        </div>
        <div class="col-xs-4 col-sm-2 pull-right">
            <input type="text" class="form-control" placeholder="Busqueda" v-model="search">
        </div>
    </div>
</template>

<style>
select {
    min-width: 70px !important;
}
</style>

<script>
    import _ from 'lodash';

    export default {
        name: 'header-table',
        props: ['n', 'c'],
        data () {
            return {
                num: this.c,
                search: ''
            };
        },
        watch: {
            search: function (newsearch, oldsearch) {this.$emit('changeS', newsearch);},
            num: function (value) {this.$emit('changeN', value);}
        }
    }
</script>