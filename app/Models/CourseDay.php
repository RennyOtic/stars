<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelsTrait;

class CourseDay extends Model
{
	use ModelsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'course_id',
    	'day_id',
    	'hour_start',
    	'hour_end',
    ];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'created_at' , 'updated_at', 'deleted_at'
    ];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}
