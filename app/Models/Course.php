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
        'company_id',
        'coordinator_id',
        'idioma_id',
        'level_id',
        'material_id',
        'teacher_id',
        'type_student_id',
        'user_id',
        'coursestate_id',
    ];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'slug', 'created_at' , 'updated_at', 'deleted_at'
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

    public function users()
    {
        return $this->belongsToMany(\App\User::class);
    }

    public function coordinator()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function days()
    {
        return $this->hasMany(CourseDay::class);
    }

    public function clase()
    {
        return $this->hasMany(Clase::class);
    }
}
