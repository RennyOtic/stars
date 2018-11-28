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
        $num_id = '';
        if (request()->type == 1) {
            $num_id = 'id';
        } elseif (request()->type == 2) {
            $num_id = 'string|min:5|max:20'; /*pass*/
        }
        return [
            'email'     => 'required|email|min:8|max:35|unique1:users',
            'last_name' => 'required|alpha_space|min:3|max:15',
            'name'      => 'required|alpha_space|min:3|max:15',
            'num_id'    => 'required|' . $num_id,
            'password'  => 'nullable|string|min:6|max:20|confirmed',
            'roles'     => 'required|min:1|max:1',
            'birthday_date' => 'required|date',
            'nationality_id' => 'required|numeric',
            'occupation' => 'required|string|max:25|min:3',
            'phone_home' => 'nullable|phone',
            'phone_movil' => 'required|phone',
            'company_id' => 'nullable|numeric',
            'type' => 'required|numeric'
        ];
    }

    /**
     * Cambio de nombres de los atributos.
     *
     * @return array
     */
    public function attributes()
    {
        $num_id = '';
        if (request()->type == 1) {
            $num_id = 'RUT';
        } elseif (request()->type == 2) {
            $num_id = 'pasaporte';
        }
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
            'company_id' => 'empresa',
            'type' => 'tipo'
        ];
    }
}
