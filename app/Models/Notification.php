<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Notification extends Model
{

	use SoftDeletes, ModelsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'assistance_id',
    	'coordinator_id',
        'student_id',
    	'state',
    	'observation',
        'reschedule'
    ];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'created_at' , 'updated_at', 'deleted_at'
    ];

    public function coordinator()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function assistance()
    {
        return $this->belongsTo(Assistance::class);
    }

    public function student()
    {
        return $this->belongsTo(\App\User::class);
    }
}
