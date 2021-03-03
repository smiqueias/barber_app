<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;

class CompanyController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api');
    }


    public function index(): JsonResponse
    {
        $companies = Company::all();

        if ($companies == null) {
            return response()->json($companies);
        }

        return response()->json(['error' => 'Response not found'],401);
    }

    public function store(Request $request): JsonResponse
    {

        $company = new Company();

         $company->name = $request->name;
         $company->latitude = $request->latitude;
         $company->longitude = $request->longitude;
         $company->phone = $request->phone;
         $company->social_link = $request->social_link;

         $company->save();

         if($company == null) return response()->json(['error' => 'Resource not found'],401);

         return response()->json($company);

    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $company = Company::find($id);

        if($company == null) return response()->json(['error' => 'Resource not found'],401);

        return response()->json($company);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): JsonResponse
    {

        $company = Company::find($id);

        $company->name = $request->name;
        $company->latitude = $request->latitude;
        $company->longitude = $request->longitude;
        $company->phone = $request->phone;
        $company->social_link = $request->social_link;

        $company->save();

        if($company == null) return response()->json(['error' => 'Resource not found update'],401);

        return response()->json($company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        $company = Company::find($id);
        $company->delete();

        if($company == null) return response()->json(['error' => 'Resource not found destroy'],401);

        return response()->json($company);
    }
}
