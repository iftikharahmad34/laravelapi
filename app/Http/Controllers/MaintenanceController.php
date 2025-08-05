<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Maintenance;

class MaintenanceController extends Controller
{
    public function Index(Request $request){

       $maintenances = Maintenance::latest()->get();
        return response()->json([
            'status' => 'success',
            'maintenances' => $maintenances
        ], 200);
    }

    public function Store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        Maintenance::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Maintenance record created successfully.'
        ], 200);

    }

    public function getSingleMaintenance($id){

        $maintenance = Maintenance::find($id);

        if (!$maintenance) {
            return response()->json([
                'status' => 'error',
                'message' => 'Maintenance record not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'maintenance' => $maintenance
        ], 200);
    }

    public function updateMaintenance(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $maintenance = Maintenance::find($id);

        if (!$maintenance) {
            return response()->json([
                'status' => 'error',
                'message' => 'Maintenance record not found.'
            ], 404);
        }

        $maintenance->name = $request->name;
        $maintenance->type = $request->type;
        $maintenance->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Maintenance record updated successfully.',
            'maintenance' => $maintenance
        ], 200);

    }

    public function DeleteMaintenance($id){

       $maintenance = Maintenance::find($id);

        if (!$maintenance) {
            return response()->json([
                'status' => 'error',
                'message' => 'Maintenance record not found.'
            ], 404);
        }

        $maintenance->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Maintenance record deleted successfully.'
        ], 200);

    }
}
