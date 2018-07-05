<template>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title"><i class="glyphicon glyphicon-compressed"></i> Tabla de Roles: </h3>
			<button type="button"
			class="btn btn-default btn-xs"
			data-tool="tooltip"
			title="Registrar Rol"
			@click="openform('create')"
			v-if="can('rol.store')"><span class="glyphicon glyphicon-plus"></span></button>
			<button type="button"
			class="btn btn-default btn-xs"
			data-tool="tooltip"
			title="Editar Rol"
			@click="openform('edit')"
			v-show="rol"
			v-if="can('rol.update')"><span class="glyphicon glyphicon-edit"></span></button>
			<button type="button"
			class="btn btn-default btn-xs"
			data-tool="tooltip"
			title="Borrar Rol"
			@click="deleted('/admin/roles/'+rol, $children[1].get, 'name')"
			v-show="rol"><span class="glyphicon glyphicon-trash"></span></button>
			<v-modal-form :formData="formData" @input="$children[1].get()"></v-modal-form>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<v-table id="rol" :columns="tabla.columns" uri="/admin/roles" @output="rol = arguments[0]"></v-table>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Tabla from './../partials/table.vue';
	import Modal from './../forms/modal-form-rol.vue';

	export default {
		name: 'Roles',
		components: {
			'v-table': Tabla,
			'v-modal-form': Modal,
		},
		data() {
			return {
				rol: null,
				formData: {
					ready: true,
					title: '',
					url: '',
					ico: '',
					cond: '',
					rol:  {
						name: '',
						slug: '',
						description: '',
						from_at: '',
						special: '',
						to_at: '',
						permissions: []
					}
				},
				tabla: {
					columns: [
					{ title: 'Nombre', field: 'name', sortable: true },
					{ title: 'Descripción', field: 'description', sortable: true },
					{ title: 'Activo', field: 'hours', sort: 'from_at', sortable: true },
					{ title: 'Acceso especial', field: 'special' },
					]
				}
			};
		},
		methods: {
			openform: function (cond, user = null) {
				this.formData.ready = false;
				if (cond == 'create') {
					this.formData.title = ' Registrar Rol.';
					this.formData.url = '/admin/roles';
					this.formData.ico = 'plus';
					this.formData.rol = {
						name: '',
						slug: '',
						description: '',
						from_at: '',
						special: '',
						to_at: '',
						permissions: []
					};
					this.formData.ready = true;
				} else if (cond == 'edit') {
					this.formData.url = '/admin/roles/' + this.rol;
					axios.get(this.formData.url)
					.then(response => {
						this.formData.ico = 'edit';
						this.formData.title = 'Editar Rol: ' + response.data.name;
						this.formData.rol = response.data;

						let permissions = response.data.permissions;
						let options = [];
						for (let permission in permissions){
							options.push(permissions[permission].id);
						}
						this.formData.rol.permissions = options;

						this.formData.ready = true;
					});
				}
				$('#rol-form').modal('toggle');
				this.formData.cond = cond;
			}
		}
	}
</script>
