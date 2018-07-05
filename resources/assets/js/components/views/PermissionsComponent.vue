<template>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title"><i class="glyphicon glyphicon-th"></i> Tabla de Permisos: </h3>
			<button type="button"
			class="btn btn-default btn-xs"
			data-tool="tooltip"
			title="Editar Permiso"
			@click="openform('edit')"
			v-show="permission"><span class="glyphicon glyphicon-edit"></span></button>
			<v-modal-form :formData="formData" @input="$children[1].get()"></v-modal-form>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<v-table id="permission" :columns="tabla.columns" uri="/admin/permissions" @output="permission = arguments[0]"></v-table>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Tabla from './../partials/table.vue';
	import Modal from './../forms/modal-form-permission.vue';

	export default {
		name: 'Permissions',
		components: {
			'v-table': Tabla,
			'v-modal-form': Modal,
		},
		data() {
			return {
				permission: null,
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
			openform: function (cond, user = null) {
				this.formData.ready = false;
				if (cond == 'edit') {
					this.formData.url = '/admin/permissions/' + this.permission;
					axios.get(this.formData.url)
					.then(response => {
						this.formData.ico = 'edit';
						this.formData.title = 'Editar Rol: ' + response.data.name;
						response.data.deleted_at = (response.data.deleted_at) ? true:false;
						this.formData.permission = response.data;
						$('#permission-form').modal('toggle');
						this.formData.ready = true;
					});
				}
				this.formData.cond = cond;
			}
		}
	}
</script>
