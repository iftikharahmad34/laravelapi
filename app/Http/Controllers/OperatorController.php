<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Operator;

class OperatorController extends Controller
{
    public function Index(Request $request){

        $operators = Operator::latest()->get();

        return response()->json([
            'status' => 'success',
            'operators' => $operators
        ], 200);

    }

    public function Store(Request $request){

       $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            // Add other fields if needed
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        Operator::create([
            'name' => $request->name,
            'tool_id' => $request->toolid,
            'type' => $request->type,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Operator created successfully.'
        ], 200);

    }

    public function getSingleOperator($id){

        $operator = Operator::find($id);

        if (!$operator) {
            return response()->json([
                'status' => 'error',
                'message' => 'Operator not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'operator' => $operator
        ], 200);

    }

    public function updateOperator(Request $request, $id){

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

        $operator = Operator::find($id);

        if (!$operator) {
            return response()->json([
                'status' => 'error',
                'message' => 'Operator not found.'
            ], 404);
        }

        $operator->name = $request->name;
        $operator->tool_id = $request->toolid;
        $operator->type = $request->type;
        $operator->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Operator updated successfully.',
            'operator' => $operator
        ], 200);

    }

    public function DeleteOperator($id){

        $operator = Operator::find($id);

        if (!$operator) {
            return response()->json([
                'status' => 'error',
                'message' => 'Operator not found.'
            ], 404);
        }

        $operator->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Operator deleted successfully.'
        ], 200);

    }
}
