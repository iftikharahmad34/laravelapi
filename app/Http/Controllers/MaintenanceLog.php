<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MaintenanceLog;

class MaintenanceLog extends Controller
{
    public function Index()
    {
        $logs = MaintenanceLog::latest()->get();
        return response()->json([
            'status' => 'success',
            'projects' => $logs
        ], 200);
    }

    public function Store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }
        MaintenanceLog::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Project created successfully.'
        ], 200);
    }

    public function Show($id){

        $project = MaintenanceLog::find($id);

        if (!$project) {
            return response()->json([
                'status' => 'error',
                'message' => 'Maintenance Log not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'project' => $project
        ], 200);

    }

    public function updateMaintenanceLog(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $maintenancelog = MaintenanceLog::find($id);

        if (!$maintenancelog) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found.'
            ], 404);
        }

        $maintenancelog->name = $request->name;
        $maintenancelog->save();

        return response()->json([
            'status' => 'success',
            'message' => 'maintenance log updated successfully.',
            'maintenancelog' => $maintenancelog
        ], 200);
    }

    public function MaintenanceLogDelete($id)
    {
        $maintenancelog = MaintenanceLog::find($id);

        if (!$maintenancelog) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found.'
            ], 404);
        }

        $maintenancelog->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'maintenancelog deleted successfully.'
        ], 200);
    }
}
