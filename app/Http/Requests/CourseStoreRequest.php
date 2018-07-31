<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->iCan('courseManagement', 'store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|numeric|digits:21|unique:courses',
            'date_end_at' => 'required|date',
            'date_inscription_end_at' => 'required|date',
            'date_inscription_start_at' => 'required|date',
            'date_start_at' => 'required|date',
            'hour_end' => 'required|hour_corret',
            'hour_start' => 'required|hour_corret',
            'max_students' => 'required|numeric|max:20|min:1',
            'name' => 'required|string|max:50|min:5',
            'teacher_id' => 'required|numeric',
            'idioma_id' => 'required|numeric',
            'max_class' => 'required|numeric|min:1|max:50',
            'type_student_id' => 'required',
            'level_id' => 'required|numeric',
            'class_type_id' => 'required|numeric',
            'materials' => 'nullable|array',
            'days' => 'required|array'
        ];
    }

    /**
     * Cambio de nombres de los atributos.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'code' => 'código',
            'date_end_at' => 'fecha final',
            'date_inscription_end_at' => 'fecha final',
            'date_inscription_start_at' => 'fecha inicial',
            'date_start_at' => 'fecha inicial',
            'hour_end' => 'hora final',
            'hour_start' => 'hora inicial',
            'max_students' => '',
            'name' => 'nombre',
            'teacher_id' => 'profesor',
            'idioma_id' => 'idioma',
            'max_class' => 'número maximo de alumnos',
            'type_student_id' => 'tipo de estudiantes',
            'level_id' => 'nivel',
            'class_type_id' => 'tipo de clases',
            'materials' => 'materiales',
            'days' => 'días'
        ];
    }
}
