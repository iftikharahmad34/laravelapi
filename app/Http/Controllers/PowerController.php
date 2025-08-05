<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PowerTool;

class PowerController extends Controller
{
    public function Index(Request $request){

        $powertools = PowerTool::latest()->get();

        return response()->json(['powertools' => $powertools], 200);

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

        PowerTool::create([
            'name' => $request->name,
            'tool_id' =>$request->toolid,
            'type' => $request->type,
        ]);

        return response()->json([
                'status' => 'success',
                'message' => 'Add lefting saved successfully.',
            ], 200);

    }

    public function getSinglelefting($id){

        $powertool = PowerTool::find($id);

        if (!$powertool) {
            return response()->json([
                'status' => 'error',
                'message' => 'Power tool not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'powertool' => $powertool
        ], 200);

    }

    public function updatelefting(Request $request, $id){

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

        // Find the record
        $powertool = PowerTool::find($id);

        if (!$powertool) {
            return response()->json([
                'status' => 'error',
                'message' => 'Power tool not found.'
            ], 404);
        }

        // Update fields
        $powertool->name = $request->name;
        $powertool->model = $request->model;
        $powertool->tool_id = $request->toolid;
        $powertool->type = $request->type;
        $powertool->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Power tool updated successfully.',
            'powertool' => $powertool
        ], 200);

    }

    public function Deletelefting($id){

        $powertool = PowerTool::find($id);

        if (!$powertool) {
            return response()->json([
                'status' => 'error',
                'message' => 'Power tool not found.'
            ], 404);
        }

        $powertool->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Power tool deleted successfully.'
        ], 200);

    }
}
