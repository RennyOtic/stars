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
            'name' => 'required|string|min:3|max:25',
            'permissions' => 'nullable|array',
            'special' => 'required_without:permissions',
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
            'name' => 'nombre',
            'permissions' => 'permisos',
            'special' => 'especial',
        ];
    }
}
