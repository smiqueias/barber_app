<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class ServiceController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        $services = Service::all();

        if ($services == null) {
            return response()->json(['error' => 'Not Found'],404);
        }

        return response()->json($services,200);
    }


    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'cost' => 'required',
            'employee_id' => 'required',
        ]);

        if($validator->fails()) return response()->json([$validator->errors()],422);

        $service = Service::create(array_merge(
            $validator->validated()
        ));

        return response()->json(['message' => 'Success', $service],201);
    }

    public function show($id): JsonResponse
    {
        $service = Service::find($id);

        if ($service == null) return response()->json(['error' => 'Not Found'],404);

        return response()->json($service,200);


    }


    public function update(Request $request, $id): JsonResponse
    {
        $service = Service::find($id);

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'cost' => 'required',
            'employee_id' => 'required',
        ]);

        if($validator->fails()) return response()->json([$validator->errors()],422);

        $service->update($request->all());

        return response()->json($service,201);
    }

    public function destroy($id): JsonResponse
    {
        $service = Service::find($id);

        if($service == null) return response()->json(['error' => 'Resource not found'],404);

        $service->delete();

        return response()->json($service,200);
    }
}
