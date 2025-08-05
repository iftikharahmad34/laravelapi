<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ServiceReport;

class ServiceReport extends Controller
{
    public function Index()
    {
        $reports = ServiceReport::all();
        return response()->json(['status' => 'success', 'data' => $reports], 200);
    }

    public function Store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $report = ServiceReport::create([
            'name' => $request->name,
        ]);

        return response()->json(['status' => 'success', 'data' => $report], 200);
    }

    public function Show($id)
    {
        $report = ServiceReport::find($id);

        if (!$report) {
            return response()->json(['status' => 'error', 'message' => 'Not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $report], 200);
    }

    public function updateMaintenanceLog(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $report = ServiceReport::find($id);

        if (!$report) {
            return response()->json(['status' => 'error', 'message' => 'Not found'], 404);
        }

        $report->name = $request->name;
        $report->save();

        return response()->json(['status' => 'success', 'data' => $report], 200);
    }

    public function MaintenanceLogDelete($id)
    {
        $report = ServiceReport::find($id);

        if (!$report) {
            return response()->json(['status' => 'error', 'message' => 'Not found'], 404);
        }

        $report->delete();

        return response()->json(['status' => 'success', 'message' => 'Deleted successfully'], 200);
    }
}
