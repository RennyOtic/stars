/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('./plugins/jquery-clockpicker.min.js');

import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './router';
import App from './components/App.vue';

$.material.init();

Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.mixin({
	methods: {
		can: function (accion = null) {
			let permissions = this.$root.permissions;
			if (permissions === 'all-access') return true;
			if (permissions === 'no-access') return false;
			if (Array.isArray(accion)) {
				for(let i in accion) {
					if (permissions.includes(accion[i])) return true;
				}
				return false;
			}
			return this.$root.permissions.includes(accion);
		},
		restoreMsg: function (msg) {
			for(let i in msg) {
				$('.modal small#'+i+'Help').text(msg[i]);
			}
		},
		deleted: function (url, updateTable, name = 'name') {
			let msg = toastr;
			msg.options.tapToDismiss = false;
			axios.get(url)
			.then(response => {
				msg.info(response.data[name] + '<br /><br /><button id="btn-delete" type="button" class="btn btn-success btn-raised btn-xs">Si</button> <button id="no-delete" type="button" class="btn btn-danger btn-raised btn-xs" role="button">No</button>', 'Esta seguro de Borrar este Elemento?')
			})
			.then(() => {
				$('button#btn-delete').click(function () {
					toastr.remove();
					toastr.clear();
					axios.delete(url)
					.then(response => {
						updateTable();
						toastr.success('Borrado Exitosamente');
					});
				});
				$('button#no-delete').click(function () {
					toastr.remove();
					toastr.clear();
				});
			});
		}
	}
});

Vue.component('spinner', require('./components/partials/spinner.vue'));

const app = new Vue({
	router,
	data: {
		permissions: [],
	},
	components: { App },
	mounted: function () {
		if (location.href.indexOf('/login') > 0) return;
		if (location.href.indexOf('/registro') > 0) return;
		if (location.href.indexOf('/password') > 0) return;

		axios.post('/app', {rs: 'p'})
		.then(response => {
			this.permissions = response.data;
		});
	},
}).$mount('#app');
