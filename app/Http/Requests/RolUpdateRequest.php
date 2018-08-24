<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->iCan('rol', 'update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'nullable|string',
            'from_at' => 'nullable|required_with:to_at|hour_corret',
            'name' => 'required|string|min:3|max:25',
            'permissions' => 'nullable|array',
            'slug' => 'required|min:3|max:25|unique1:roles',
            'special' => 'required_without:permissions',
            'to_at' => 'nullable|required_with:from_at|hour_corret'
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
            'description' => 'descripción',
            'from_at' => 'desde',
            'name' => 'nombre',
            'permissions' => 'permisos',
            'slug' => 'alias',
            'special' => 'especial',
            'to_at' => 'hasta'
        ];
    }
}
