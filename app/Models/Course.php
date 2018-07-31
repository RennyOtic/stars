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
        'class_type_id',
        'code',
        'date_end_at',
        'date_inscription_end_at',
        'date_inscription_start_at',
        'date_start_at',
        'hour_end',
        'hour_start',
        'idioma_id',
        'level_id',
        'max_class',
        'max_students',
        'name',
        'slug',
        'teacher_id',
        'type_student_id',
        'user_id',
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

    public function days()
    {
        return $this->belongsToMany(Day::class);
    }
}
