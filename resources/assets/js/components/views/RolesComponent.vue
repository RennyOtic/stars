<template>
	<div class="box">
		<div class="box-header text-center">
			<button type="button"
			class="btn btn-info btn-raised btn-xs"
			data-tooltip="tooltip"
			title="Lista de Usuarios"
			@click="show = 1"
			v-if="can('user.index')"
			v-show="show == 2"><span class="glyphicon glyphicon-list"></span></button>
			<button type="button"
			class="btn btn-success btn-raised btn-xs"
			data-tooltip="tooltip"
			title="Registrar Rol"
			@click="openform('create')"
			v-if="can('rol.store')"
			v-show="show == 1"><span class="glyphicon glyphicon-plus"></span></button>
			<button type="button"
			class="btn btn-info btn-raised btn-xs"
			data-tooltip="tooltip"
			title="Editar Rol"
			@click="openform('edit')"
			v-show="id && show == 1"
			v-if="can('rol.update')"><span class="glyphicon glyphicon-edit"></span></button>
			<button type="button"
			class="btn btn-danger btn-raised btn-xs"
			data-tooltip="tooltip"
			title="Borrar Rol"
			@click="deleted('/admin/roles/'+id, $children[1].get, 'name')"
			v-show="id && show == 1"
			v-if="can('rol.destroy')"><span class="glyphicon glyphicon-trash"></span></button>
		</div>
		<div class="box-body">
			<rs-form :formData="formData"
			@input="$children[1].get()"
			v-if="can(['rol.store','rol.update'])"
			v-show="show == 2"></rs-form>
			<rs-table :columns="tabla.columns"
			uri="/admin/roles"
			@output="id = arguments[0]"
			v-show="show == 1"></rs-table>
		</div>
	</div>
</template>

<script>
	import Tabla from './../partials/table.vue';
	import Modal from './../forms/Form-rol.vue';

	export default {
		name: 'Roles',
		components: {
			'rs-table': Tabla,
			'rs-form': Modal,
		},
		data() {
			return {
				show: 1,
				id: 0,
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
					this.formData.title = 'Registrar Rol.';
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
					this.formData.url = '/admin/roles/' + this.id;
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
                this.show = 2;
				this.formData.cond = cond;
			}
		}
	}
</script>
