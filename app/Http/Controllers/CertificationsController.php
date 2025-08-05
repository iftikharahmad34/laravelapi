<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Certifications;

class CertificationsController extends Controller
{
    public function Index(Request $request){

        $certifications = Certification::latest()->get();
        return response()->json([
            'status' => 'success',
            'certifications' => $certifications
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

        Certification::create([
            'name' => $request->name,
            'model' => $request->model,
            'type' => $request->type,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Certification created successfully.'
        ], 200);

    }

    public function getSingleCertifications($id){
        $certification = Certification::find($id);

        if (!$certification) {
            return response()->json([
                'status' => 'error',
                'message' => 'Certification not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'certification' => $certification
        ], 200);

    }

    public function updateCertifications(Request $request, $id){

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

        $certification = Certification::find($id);

        if (!$certification) {
            return response()->json([
                'status' => 'error',
                'message' => 'Certification not found.'
            ], 404);
        }

        $certification->name = $request->name;
        $certification->type = $request->type;
        $certification->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Certification updated successfully.',
            'certification' => $certification
        ], 200);
    }

    public function DeleteCertifications($id){

        $certification = Certification::find($id);

        if (!$certification) {
            return response()->json([
                'status' => 'error',
                'message' => 'Certification not found.'
            ], 404);
        }

        $certification->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Certification deleted successfully.'
        ], 200);

    }
}
