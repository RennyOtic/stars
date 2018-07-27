<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Course extends Model
{
	use SoftDeletes, ModelsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'code',
        'hour_start',
        'hour_end',
        'idioma_id',
        'teacher_id',
        'user_id',
        'max_students',
        'max_class',
        // 'type_student_id',
        'level_id',
        'class_type_id',
        'date_start_at',
        'date_inscription_start_at',
        'date_inscription_end_at',
        'date_end_at',
    ];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'created_at' , 'updated_at', 'deleted_at'
    ];

    public function teacher()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function idioma()
    {
        return $this->belongsTo(Idioma::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class);
    }

    public function users()
    {
        return $this->belongsToMany(\App\User::class);
    }
}
