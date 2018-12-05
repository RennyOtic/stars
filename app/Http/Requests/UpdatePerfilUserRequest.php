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
        $user = \App\User::where('email', request()->email)->first();
        $num_id = '';
        if ($user->type == 1) {
            $num_id = 'id';
        } elseif ($user->type == 2) {
            $num_id = 'string|min:5|max:20'; /*pass*/
        }
        return [
            'email' => 'required|email|unique1:users,email',
            'last_name' => 'required|alpha_space|min:3|max:20',
            'name' => 'required|alpha_space|min:3|max:20',
            'num_id' => 'required|' . $num_id . '|unique1:users,num_id'
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
            'num_id' => 'RUT/Pasaporte'
        ];
    }
}
