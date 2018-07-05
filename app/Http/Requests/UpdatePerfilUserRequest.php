<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerfilUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|DomainValid|unique1:users,email',
            'last_name' => 'required|alpha_space|min:3|max:20',
            'name' => 'required|alpha_space|min:3|max:20',
            'num_id' => 'required|numeric|exr_ced|unique1:users,num_id'
        ];
    }

    /**
     * Translate name of atributes.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => 'correo',
            'last_name' => 'apellido',
            'name' => 'nombre',
            'num_id' => 'cédula'
        ];
    }
}
