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
            'teacher_id' => 'required|numeric',
            'coordinator_id' => 'required|numeric',
            'idioma_id' => 'required|numeric',
            'company_id' => 'required|numeric',
            'type_student_id' => 'required',
            'level_id' => 'required|numeric',
            'class_type_id' => 'required|numeric',
            'material_id' => 'required|numeric',
            'days' => 'required|array|is_hour_correct_array'
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
            'coordinator_id' => 'coordinador',
            'teacher_id' => 'profesor',
            'company_id' => 'empresa',
            'idioma_id' => 'idioma',
            'max_class' => 'número maximo de alumnos',
            'type_student_id' => 'tipo de estudiantes',
            'level_id' => 'nivel',
            'class_type_id' => 'tipo de clases',
            'material_id' => 'materiales',
            'days' => 'días'
        ];
    }
}
