<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ { UserStoreRequest, UserUpdateRequest, ChangePasswordRequest };
use App\User;
use App\Models\ { Nationality, Course, HowFind, Company };
use App\Models\Permisologia\Role;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:user,index')->only(['index', 'dataForRegister']);
        $this->middleware('can:user,show')->only(['show']);
        $this->middleware('can:user,destroy')->only(['destroy']);
    }

    /**
     * Muestra una lista de recursos en json o la vista.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::dataForPaginate(['name','id','last_name','email','num_id'], function ($u) {
            $rol = '';
            foreach ($u->roles as $r) {
                $rol .= '<span class="badge">' . $r->name . '</span>';
            }
            $u->rol = $rol;
            unset($u->roles);
            $u->fullName = $u->fullName();
        });
        return $this->dataWithPagination($users);
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     *
     * @param  \App\Http\Requests\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        // $data['roles'] = $this->idsOfRol($data['roles']);
        $user = new User($data);
        $user->password = bcrypt($data['password']);
        $user->save();
        $user->roles()->attach($data['roles']);
        $user->assignPermissionsOneUser([$data['roles']]);
    }

    /**
     * Mostrar el recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $user->fullName = $user->fullName();
        $user->roles;
        $howfind = HowFind::where('name', '=', $user->how_find)->first();
        if (!$howfind && !is_null($user->how_find)) {
            $user->how_find_other = $user->how_find;
            $user->how_find = 'Otro';
        }
        return response()->json($user);
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     *
     * @param  \App\Http\Requests\UserUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        if($request->id == 1) return response(['errors' => 'Error al modificar usuario'], 422);

        $data = $request->validated();
        // $data['roles'] = $this->idsOfRol($data['roles']);

        if( !empty($request->password) ){
            $data['password'] = bcrypt($this->validate($request, [
                'password' => 'string|min:6|confirmed'
            ])['password']);
        }

        $user = User::findOrFail($id)->fill($data);
        $user->update_pivot([$data['roles']], 'roles', 'role_id');
        $user->assignPermissionsOneUser([$data['roles']]);
        $user->save();
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id === 1) return response(['msg' => 'Error al modificar usuario'], 422);
        $user = User::findOrFail($id);
        $courses = Course::where('teacher_id', '=', $user->id)->get();
        $courses->each(function ($c) {
            $c->update(['teacher_id' => null]);
        });
        return response()->json($user->delete());
    }

    /**
     * Retorna los datos que se usaran para crear y editar.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister()
    {
        $roles = Role::where('id', '>=', \Auth::user()->roles->first()->id)->get(['name', 'id']);
        $nationalities = Nationality::get(['name', 'id']);
        $howfinds = HowFind::get(['name', 'id']);
        $companies = Company::get(['name', 'id', 'rut']);
        $companies->each(function ($c) {
            $c->text = $c->name . ' - ' . $c->rut;
            unset($c->pivot, $c->name, $c->rut);
        });
        return response()->json(compact('roles', 'nationalities', 'howfinds', 'companies'));
    }

}
