<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;

class CompanyController extends Controller
{

    public function __construct()
    {
        $this->middleware('onlyAjax');
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
            'rut' => 'required|numeric|digits_between:6,11|unique:companies',/*exr_ced*/
            'email' => 'required|email|DomainValid|unique:companies,email',
            'phone' => 'required|numeric|digits_between:6,10',
            'name_c' => 'required|string|min:2|max:40',
            'email_c' => 'nullable|email|DomainValid|unique:companies,email_c',
            'phone_c' => 'nullable|numeric|digits_between:6,10',
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
            'rut' => 'required|numeric|digits_between:6,11|unique1:companies',/*exr_ced*/
            'email' => 'required|email|DomainValid|unique1:companies,email',
            'phone' => 'required|numeric|digits_between:6,10',
            'name_c' => 'required|string|min:2|max:40',
            'email_c' => 'nullable|email|DomainValid|unique1:companies,email_c',
            'phone_c' => 'nullable|numeric|digits_between:6,10',
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
        Company::findOrFail($id)->delete();
    }
}
