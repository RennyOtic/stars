<?php

namespace App\Models\Permisologia;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Permission extends Model
{
	use SoftDeletes, ModelsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'name', 'module', 'action', 'description'
	];

	/**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'created_at' , 'updated_at'
    ];


    /**
     * Los atruburos que seran instancia de carbon por ser tipo fecha.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Obtener los roles que posee el permiso.
     */
	public function roles()
	{
		return $this->belongsToMany(Role::class);
	}

    /**
     * Obtener los usuario que posee el permiso.
     */
    public function users()
    {
        return $this->belongsToMany(\App\User::class);
    }
}
