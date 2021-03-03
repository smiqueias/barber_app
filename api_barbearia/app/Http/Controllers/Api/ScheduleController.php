<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class ScheduleController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        $schedules = Schedule::all();

        if ($schedules == null) {
            return response()->json(['error' => 'Not Found'],404);
        }

        return response()->json($schedules,200);
    }


    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'schedule_date' => 'required',
            'employee_id' => 'required',
            'service_id' => 'required'
        ]);

        if($validator->fails()) return response()->json([$validator->errors()],422);

        $schedule = Schedule::create(array_merge(
            $validator->validated()
        ));

        return response()->json(['message' => 'Success', $schedule],201);
    }

    public function show($id): JsonResponse
    {
        $schedule = Schedule::find($id);

        if ($schedule == null) return response()->json(['error' => 'Not Found'],404);

        return response()->json($schedule,200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $schedule = Schedule::find($id);

        $validator = Validator::make($request->all(),[
            'schedule_date' => 'required',
            'employee_id' => 'required',
            'service_id' => 'required'
        ]);

        if($validator->fails()) return response()->json([$validator->errors()],422);

        $schedule->update($request->all());

        return response()->json($schedule,201);
    }

    public function destroy($id): JsonResponse
    {
        $schedule = Schedule::find($id);

        if($schedule == null) return response()->json(['error' => 'Resource not found'],404);

        $schedule->delete();

        return response()->json($schedule,200);
    }
}
