<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;

class CompanyController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:company,index')->only(['index', 'dataForRegister']);
        $this->middleware('can:company,store')->only(['store']);
        $this->middleware('can:company,show')->only(['show']);
        $this->middleware('can:company,update')->only(['update']);
        $this->middleware('can:company,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::dataForPaginate(['id', 'name', 'rut', 'phone', 'name_c', 'email_c']);
        return $this->dataWithPagination($company);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string|min:2|max:40',
            'rut' => 'required|id|unique:companies',/*exr_ced*/
            'email' => 'required|email|unique:companies',
            'phone' => 'required|phone',
            'name_c' => 'required|string|min:2|max:40',
            'email_c' => 'nullable|email|unique:companies',
            'phone_c' => 'nullable|phone',
        ],[],[
            'name' => 'nombre',
            'rut' => 'RUT',
            'email' => 'correo',
            'phone' => 'teléfono',
            'name_c' => 'nombre',
            'email_c' => 'correo',
            'phone_c' => 'teléfono',
        ]);
        Company::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::findOrFail($id);
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required|string|min:2|max:40',
            'rut' => 'required|id|unique1:companies',/*exr_ced*/
            'email' => 'required|email|unique1:companies,email',
            'phone' => 'required|phone',
            'name_c' => 'required|string|min:2|max:40',
            'email_c' => 'nullable|email|unique1:companies,email_c',
            'phone_c' => 'nullable|phone',
        ],[],[
            'name' => 'nombre',
            'rut' => 'RUT',
            'email' => 'correo',
            'phone' => 'teléfono',
            'name_c' => 'nombre',
            'email_c' => 'correo',
            'phone_c' => 'teléfono',
        ]);
        Company::findOrFail($id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $users = $company->users->count();
        if ($users) return response()->json(['message' => 'Esta empresa tiene ' . $users . ' usuarios Asignados.'], 401);
        $company->delete();
    }
}
