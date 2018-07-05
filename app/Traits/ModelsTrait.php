<?php

namespace App\Traits;

use App\Models\Permisologia\Role;

trait ModelsTrait
{

	/**
	 * ruta de la imagen del usuario.
	 * @model User
	 * @return string
	 */
	public function getLogoPath()
	{
		$path = public_path('storage\users\image\\') . \Auth::user()->id . '.';
		$ext = ['jpg', 'jpeg', 'png'];

		foreach ($ext as $e) {
			if (is_readable($path . $e)) {
				return asset('storage\users\image\\') . \Auth::user()->id . '.' . $e;
			}
		}
		return "/adminlte/img/icon-avatar-default.png";
	}

	/**
	 * Nombre completo del usuario.
	 * @model User
	 * @return string
	 */
	public function fullName()
	{
		$name = explode(' ', $this->name);
		$last_name = explode(' ', $this->last_name);
		return ucfirst($name[0]) . ' ' . ucfirst($last_name[0]);
	}

	/**
	 * Asigna los permisos de la tabla permission_user de un solo usuario.
	 * @model User
	 * @return Bool
	 */
	public function assignPermissionsOneUser($roles)
	{
		$permissions = [];
		foreach ($roles as $rol) {
			$permissionsOfRol = Role::findOrFail($rol)->permissions->pluck('id')->toArray();
			$permissions = array_merge($permissions, $permissionsOfRol);
		}
		return $this->update_pivot(array_unique($permissions), 'permissions', 'permission_id');
	}

	/**
	 * Devuelve todos los permisos que posee el usuario.
	 * @model User
	 * @return $this
	 */
	public function permissionsOfUser()
	{
		if ($this->id == 1) return 'all-access';
		foreach ($this->roles as $rol) {
			if ($rol->special == 'all-access') return $rol->special;
			if ($rol->special == 'no-access') return [];
		}
		$all = [];
		foreach ($this->permissions as $p) {
			$all[] = $p->module . '.' . $p->action;
		}
		return $all;
	}

	/**
	 * Actualiza las tablas pivot quitando o agregando nuevos valores.
	 * @model Role || User
	 * @return $this
	 */
	public function update_pivot(Array $values = [], $relation, $campo = 'id')
	{
		$user_roles = $this->$relation()->pluck($campo)->toArray();
		$add    = array_diff($values, $user_roles);
		$delete = array_diff($user_roles, $values);
		if(!empty($add)) $this->$relation()->attach($add);
		if (!empty($delete)) $this->$relation()->detach($delete);
		return $this;
	}

	/**
	 * Actualiza las tablas pivot de user_permission.
	 * @model Role
	 * @return $this
	 */
	public function assignPermissionsAllUser()
	{
		$permissions = $this->permissions->pluck('id')->toArray();
		foreach ($this->users as $user) {
			$user->update_pivot($permissions, 'permissions', 'permission_id');
		}
		return $this;
	}

	/**
	 * Se ordenan los datos para la paginación de la tabla.
	 * @model All
	 * @return Object
	 */
	public static function dataForPaginate($select = ['*'])
	{
		return Self::orderBy(request()->order?:'id', request()->dir?:'DESC')
		->search(request()->search)
		->select($select)
		->paginate(request()->num?:10);
	}

	/**
	 * Realiza una busqueda por palabras al campo fillable.
	 * @model All
	 * @return Object
	 */
	public function scopeSearch($query, $keyword = '')
	{
		if (empty($keyword)) return $query;

		$words = explode(' ', $keyword);
		foreach ($this->fillable as $column) {
			foreach ($words as $word) {
				$query->orWhere($column, 'like', "%{$word}%");
			}
		}
		return $query;
	}
}