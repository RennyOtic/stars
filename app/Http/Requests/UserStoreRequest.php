<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->iCan('user', 'store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required|email|min:8|max:35|unique:users|DomainValid',
            'last_name' => 'required|alpha_space|min:3|max:15',
            'position'  => 'nullable|alpha_space|min:3|max:30',
            'name'      => 'required|alpha_space|min:3|max:15',
            'num_id'    => 'required|numeric|digits_between:6,8|exr_ced|unique:users',
            'password'  => 'required|string|min:6|max:20|confirmed',
            'roles'     => 'required|array|max:1'
        ];
    }

    /**
     * mensajes personalizados.
     *
     * @return array
     */
    public function messages()
    {
        return ['email.required' => 'El campo :attribute es requerido.'];
    }

    /**
     * Cambio de nombres de los atributos.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email'     => 'correo',
            'last_name' => 'apellido',
            'name'      => 'nombre',
            'num_id'    => 'cédula',
            'password'  => 'contraseña',
            'position'  => 'cargo',
            'roles'     => 'roles'
        ];
    }
}
