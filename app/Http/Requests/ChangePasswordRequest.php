<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'passwordOld' => 'required|string|min:6|current_password',
            'password' => 'required|string|min:6|confirmed|different:passwordOld',
            'password_confirmation' => 'required|string|min:6|same:password',
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
            'passwordOld' => 'contraseña actual',
            'password' => 'contraseña nueva',
            'password_confirmation' => 'confirmación de contraseña',
        ];
    }
}
