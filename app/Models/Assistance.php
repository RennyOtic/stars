<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Assistance extends Model
{
	use SoftDeletes, ModelsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'course_id', 'user_id', 'event_id', 'finish_at'
    ];

    /**
     * Los atruburos que seran instancia de carbon por ser tipo fecha.
     *
     * @var array
     */
    protected $dates = ['finish_at'];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'created_at' , 'updated_at', 'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function event()
    {
        return $this->belongsTo(EventAssistance::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function assistances_control()
    {
        return $this->hasMany(AssistancesControl::class);
    }
}
