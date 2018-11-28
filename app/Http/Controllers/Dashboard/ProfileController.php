<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\ { ChangePasswordRequest, UpdatePerfilUserRequest };

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = \Auth::user();
        $user->fullName = $user->fullName();
        $user->logoPath = $user->getLogoPath();
        $user->roles;
        return response()->json($user);
    }

    /**
     * Edita datos del usuario.
     *
     * @param  \App\Http\Requests\UpdatePerfilUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function editUser(Request $request)
    {
        if (\Auth::user()->type == 1) {
            $num_id = 'id';
        } elseif (\Auth::user()->type == 2) {
            $num_id = 'pass';
        } else {
            $num_id = 'min:1|max:1';
        }
        $data = $request->validate([
            'email' => 'required|email|unique1:users,email',
            'last_name' => 'required|alpha_space|min:3|max:20',
            'name' => 'required|alpha_space|min:3|max:20',
            'num_id'    => 'required|' . $num_id . '|unique1:users,num_id',
        ],[],[
            'email' => 'correo',
            'last_name' => 'apellido',
            'name' => 'nombre',
            'num_id' => 'RUT'
        ]);
        $data['name'] = ucfirst($data['name']);
        $data['last_name'] = ucfirst($data['last_name']);
        $user = \Auth::user()->update($data);
        if ($request->hasFile('image')) {
            $extension = $request->image->getClientOriginalExtension();
            $url = $request->image->storeAs('users/image', \Auth::user()->id.'.'.$extension);
        }
        return response()->json($user);
    }

    /**
     * Edita el password del usuario logueado.
     *
     * @param  \App\Http\Requests\ChangePasswordRequest $request
     * @return \Illuminate\Http\Response
     */
    public function editPassword(ChangePasswordRequest $request)
    {
        \Auth::user()->update([
            'password' => bcrypt($request->password)
        ]);
    }

}
