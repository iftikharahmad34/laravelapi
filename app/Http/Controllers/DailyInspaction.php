<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DailyInspaction;

class DailyInspaction extends Controller
{
    public function Index(Request $request){
       $inspaction = DailyInspaction::latest()->get();
        return response()->json([
            'status' => 'success',
            'projects' => $inspaction
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        DailyInspaction::create([
            'name' => $request->name,
            'category' => $request->category,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Daily Inspection created successfully.']);
    }

    public function getSingleIntegration($id)
    {
        $inspaction = DailyInspaction::find($id);
        if (!$inspaction) {
            return response()->json(['status' => 'error', 'message' => 'Not found.'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $inspaction], 200);
    }

    public function updateIntegration(Request $request, $id)
    {
        $inspaction = DailyInspaction::find($id);
        if (!$inspaction) {
            return response()->json(['status' => 'error', 'message' => 'Not found.'], 404);
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

        return response()->json(['status' => 'success', 'message' => 'Daily Inspection updated successfully.']);
    }

    public function DeleteIntegration($id)
    {
        $inspaction = DailyInspaction::find($id);
        if (!$inspaction) {
            return response()->json(['status' => 'error', 'message' => 'Not found.'], 404);
        }

        $inspaction->delete();

        return response()->json(['status' => 'success', 'message' => 'Daily Inspection deleted successfully.']);
    }
}
