<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permisologia\Permission;
use App\Http\Requests\PermissionUpdateRequest;

class PermissionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('onlyAjax');
        $this->middleware('can:permission,index')->only(['index']);
        $this->middleware('can:permission,show')->only(['show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permissions = Permission::withTrashed()
        ->orderBy(request()->order?:'id', request()->dir?:'DESC')
        ->search(request()->search)
        ->paginate(request()->num?:10);

        $permissions->each(function ($p) {
            $p->action = $p->module . '.' . $p->action;
            $p->active = ($p->deleted_at) ? 
            '<i class="glyphicon glyphicon-unchecked text-center"></i>' : 
            '<i class="glyphicon glyphicon-check text-center"></i>';
        });

        return $this->dataWithPagination($permissions);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::withTrashed()->findOrFail($id);
        return response()->json($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PermissionUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, $id)
    {
        $permission = Permission::withTrashed()->findOrFail($id);
        ($request->deleted_at) ? $permission->delete() : $permission->restore();
        $permission->update($request->validated());
        return response()->json($permission);
    }
}
