<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->iCan('user', 'update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required|email|min:8|max:35|unique1:users',
            'last_name' => 'required|alpha_space|min:3|max:15',
            'name'      => 'required|alpha_space|min:3|max:15',
            'num_id'    => 'required|string|digits_between:6,12|unique1:users', // exr_ced
            'password'  => 'nullable|string|min:6|max:20|confirmed',
            'roles'     => 'required',
            'birthday_date' => 'required|date',
            'nationality_id' => 'required|numeric',
            'occupation' => 'required|string|max:25|min:3',
            'phone_home' => 'nullable|numeric|digits_between:8,11',
            'phone_movil' => 'required|numeric|digits_between:8,11',
            'company_id' => 'nullable|numeric',
        ];
    }

    /**
     * Cambio de nombres de los atributos.
     *
     * @return array
     */
    public function attributes()
    {
        $num_id = (1) ? 'RUT' : 'Pasaporte';
        return [
            'email'     => 'correo',
            'last_name' => 'apellido',
            'name'      => 'nombre',
            'num_id'    => $num_id,
            'password'  => 'contraseña',
            'birthday_date' => 'fecha de cumpleaños',
            'nationality_id' => 'nacionalidad',
            'occupation' => 'ocupación',
            'phone_home' => 'telefono de contacto',
            'phone_movil' => 'telefono movil',
            'roles'     => 'perfiles',
            'company_id' => 'empresa'
        ];
    }
}
