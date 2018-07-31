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
            'email'     => 'required|email|min:8|max:35|unique:users',
            'last_name' => 'required|alpha_space|min:3|max:15',
            'name'      => 'required|alpha_space|min:3|max:15',
            'num_id'    => 'required|numeric|digits_between:6,8|exr_ced|unique:users',
            'password'  => 'required|string|min:6|max:20|confirmed',
            'roles'     => 'required',
            'birthday_date' => 'required|date',
            'nationality_id' => 'required|numeric',
            'occupation' => 'required|string|max:25|min:3',
            'phone_home' => 'required|numeric|digits:10',
            'phone_movil' => 'required|numeric|digits:10',
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
            'roles'     => 'roles',
            'birthday_date' => 'fecha de cumpleaños',
            'nationality_id' => 'nacionalidad',
            'occupation' => 'ocupación',
            'phone_home' => 'telefono de contacto',
            'phone_movil' => 'telefono movil',
        ];
    }
}
