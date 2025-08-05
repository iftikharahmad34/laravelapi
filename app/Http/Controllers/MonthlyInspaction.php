<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MonthlyInspaction;

class MonthlyInspaction extends Controller
{
    public function Index()
    {
        $data = MonthlyInspaction::all();
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function Store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $inspaction = MonthlyInspaction::create([
            'name' => $request->name,
            'category' => $request->category,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Daily Inspection created successfully.',
            'data' => $inspaction
        ]);
    }

    public function Show($id)
    {
        $inspaction = MonthlyInspaction::find($id);

        if (!$inspaction) {
            return response()->json(['status' => 'error', 'message' => 'Not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $inspaction]);
    }

    public function updateMonthlyInspaction(Request $request, $id)
    {
        $inspaction = MonthlyInspaction::find($id);

        if (!$inspaction) {
            return response()->json(['status' => 'error', 'message' => 'Not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $inspaction->name = $request->name;
        $inspaction->category = $request->category;
        $inspaction->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Daily Inspection updated successfully.',
        ]);
    }

    public function MonthlyInspactionDelete($id)
    {
        $inspaction = MonthlyInspaction::find($id);

        if (!$inspaction) {
            return response()->json(['status' => 'error', 'message' => 'Not found'], 404);
        }

        $inspaction->delete();

        return response()->json(['status' => 'success', 'message' => 'Daily Inspection deleted successfully.']);
    }
}
