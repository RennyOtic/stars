<template>
	<div class="box">
		<div class="box-header text-center">
			<button type="button"
			class="btn btn-info btn-raised btn-xs"
			data-tooltip="tooltip"
			title="Lista de Usuarios"
			@click="show = 1"
			v-if="can('permission.index')"
			v-show="show == 2"><span class="glyphicon glyphicon-list"></span></button>
			<button type="button"
			class="btn btn-info btn-raised btn-xs"
			data-tooltip="tooltip"
			title="Editar Permiso"
			@click="openform('edit')"
			v-if="can('permission.show')"
			v-show="id && show == 1"><span class="glyphicon glyphicon-edit"></span></button>
		</div>
		<div class="box-body">
			<rs-form :formData="formData"
			@input="$children[1].get()"
			v-if="can('permission.update')"
			v-show="show == 2"></rs-form>
			<rs-table :columns="tabla.columns"
			uri="/admin/permissions"
			@output="id = arguments[0]"
			v-show="show == 1"></rs-table>
		</div>
	</div>
</template>

<script>
	import Tabla from './../partials/table.vue';
	import Modal from './../forms/Form-permission.vue';

	export default {
		name: 'Permissions',
		components: {
			'rs-table': Tabla,
			'rs-form': Modal,
		},
		data() {
			return {
				show: 1,
				id: null,
				formData: {
					ready: true,
					title: '',
					url: '',
					ico: '',
					cond: '',
					permission:  {}
				},
				tabla: {
					columns: [
					{ title: 'Nombre', field: 'name', sortable: true },
					{ title: 'Descripción', field: 'description', sortable: true },
					{ title: 'Acción', field: 'action', sort: 'module', sortable: true },
					{ title: 'Activo', field: 'active', sort: 'deleted_at', sortable: true, class: 'text-center' }
					]
				}
			};
		},
		methods: {
			openform: function (cond) {
				this.formData.ready = false;
				if (cond == 'edit') {
					this.formData.url = '/admin/permissions/' + this.id;
					axios.get(this.formData.url)
					.then(response => {
						this.formData.ico = 'edit';
						this.formData.title = 'Editar Rol: ' + response.data.name;
						response.data.deleted_at = (response.data.deleted_at) ? true : false;
						this.formData.permission = response.data;
						this.formData.ready = true;
					});
				}
				this.show = 2;
				this.formData.cond = cond;
			}
		}
	}
</script>
