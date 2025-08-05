<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Lefting;

class LeftingController extends Controller
{
    public function Index(Request $request){

        $leftingtools = Lefting::latest()->get();
        return response()->json([';eftingtools' => $leftingtools], 200);
    }

    public function Store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            // Add more validation rules if needed
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        Lefting::create([
            'name' => $request->name,
            'tool_id' => $request->toolid,
            'type' => $request->type,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Lefting created successfully.'
        ], 200);

    }

    public function getSinglePower($id){

        $lefting = Lefting::find($id);

        if (!$lefting) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lefting record not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'lefting' => $lefting
        ], 200);

    }

    public function updatePower(Request $request, $id){

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

        $lefting = Lefting::find($id);

        if (!$lefting) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lefting record not found.'
            ], 404);
        }

        $lefting->name = $request->name;
        $lefting->tool_id = $request->toolid;
        $lefting->type = $request->type;
        $lefting->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Lefting updated successfully.',
            'lefting' => $lefting
        ], 200);

    }

    public function DeletePower($id){

        $lefting = Lefting::find($id);

        if (!$lefting) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lefting record not found.'
            ], 404);
        }

        $lefting->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Lefting deleted successfully.'
        ], 200);

    }

}
