<template>
    <div class="row">
        <div class="col-sm-1 pull-left">
            <div class="form-group label-floating">
                <select class="form-control" v-model="num">
                    <option v-for="i in n" :value="i" v-text="i"></option>
                </select>
            </div>
        </div>
        <div class="col-xs-4 col-sm-2 pull-right" v-if="sh_s">
            <div class="form-group label-floating">
                <input type="text" class="form-control" placeholder="Busqueda" v-model="search">
            </div>
        </div>
    </div>
</template>

<style>
input[type="text"] {
    min-width: 100% !important;
}
select {
    padding: 10px !important;
    min-width: 70px !important;
}
</style>

<script>
    import _ from 'lodash';

    export default {
        name: 'header-table',
        props: ['n', 'c', 'sh_s'],
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