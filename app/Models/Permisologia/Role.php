<?php

namespace App\Models\Permisologia;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Role extends Model
{
	use SoftDeletes, ModelsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'name', 'slug', 'description', 'from_at', 'to_at', 'special', 'deleted_at'
	];

    /**
     * Los atruburos que seran instancia de carbon por ser tipo fecha.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'created_at' , 'updated_at'
    ];

    /**
     * Obtener los usuarios que posee el rol.
     */
	public function users()
	{
		return $this->belongsToMany(\App\User::class);
	}

    /**
     * Obtener los roles que posee el rol.
     */
	public function permissions()
	{
		return $this->belongsToMany(Permission::class);
	}
}