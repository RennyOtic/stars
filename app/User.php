<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\ { ModelsTrait, PermissionTrait };

class User extends Authenticatable
{
    use Notifiable, ModelsTrait, PermissionTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'birthday_date',
        'company_id',
        'email',
        'how_find',
        'last_name',
        'name',
        'nationality_id',
        'num_id',
        'occupation',
        'password',
        'phone_home',
        'phone_movil',
    ];


    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Obtener los roles que posee el usuario.
     */
    public function roles()
    {
        return $this->belongsToMany(Models\Permisologia\Role::class);
    }

    /**
     * Obtener los permisos que posee el usuario.
     */
    public function permissions()
    {
        return $this->belongsToMany(Models\Permisologia\Permission::class);
    }

    public function courses()
    {
        return $this->belongsToMany(\App\Models\Course::class);
    }
}
