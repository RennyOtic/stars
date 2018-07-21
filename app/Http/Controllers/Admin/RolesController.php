<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permisologia\ { Role, Permission };
use App\Http\Requests\ { RolStoreRequest, RolUpdateRequest };

class RolesController extends Controller
{

    public function __construct()
    {
        $this->middleware('onlyAjax');
        $this->middleware('can:rol,index')->only(['index']);
        $this->middleware('can:rol,show')->only(['show']);
        $this->middleware('can:rol,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::dataForPaginate(['name', 'id', 'from_at', 'description', 'special', 'to_at'], function ($r) {
            $r->hours = $r->from_at . ' - ' . $r->to_at;
            if (!$r->from_at && !$r->to_at) $r->hours = 'Todo el tiempo';
        });
        return $this->dataWithPagination($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RolStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolStoreRequest $request)
    {
        $rol = Role::create($request->validated());
        if (!$request->special) {
            $rol->update_pivot($request->permissions, 'permissions')
                ->assignPermissionsAllUser()
                ;
            $rol->permissions()->attach($request->special);
            $rol->update_pivot($request->permissions, 'permissions', 'permission_id');
            $rol->assignPermissionsAllUser();
        }
        return response()->json($rol);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rol = Role::findOrFail($id);
        $rol->permissions;
        return response()->json($rol);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RolUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolUpdateRequest $request, $id)
    {
        if($request->id == 1) return response(['errors' => 'Error al modificar Rol'], 422);
        $rol = Role::findOrFail($id)->fill($request->validated());
        if(!$request->special) {
            $rol->update_pivot($request->permissions, 'permissions', 'id')
                ->assignPermissionsAllUser();
        } else {
            $rol->permissions()->detach($request->permissions);
        }
        return response()->json($rol->save());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id == 1) return response(['msg' => 'Error al modificar usuario'], 422);
        $rol = Role::findOrFail($id)->delete();
        return response()->json($rol);
    }

    /**
     * Retorna los datos que se usaran para crear y editar.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister()
    {
        $permissions = Permission::select('name', 'id', 'module', 'action')->get();
        return response()->json(compact(['permissions']));
    }

}
