<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        $employees = Employee::with('company','service','user','schedule')->get();

        if ($employees == null) {
            return response()->json(['error' => 'Response not found'],404);
        }

        return response()->json($employees,'200');
    }


    public function store(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 422);
        }

        $employee = Employee::create(array_merge(
            $validator->validated(),
        ));

        return response()->json([
            'message' => 'Success',
            $employee
        ],201);


    }


    public function show($id): JsonResponse
    {
        $employee = Employee::find($id);

        if ($employee == null) return response()->json(['error' => 'Resource not found'],404);

        return response()->json($employee);
    }

    public function update(Request $request, $id):JsonResponse
    {
        $employee = Employee::find($id);

        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required',
            'user_id' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $employee->update($request->all());

        return response()->json($employee,201);

    }

    public function destroy($id):JsonResponse
    {
        $employee = Employee::find($id);

        if($employee == null) return response()->json(['error' => 'Resource not found'],404);

        $employee->delete();

        return response()->json($employee,200);

    }
}
