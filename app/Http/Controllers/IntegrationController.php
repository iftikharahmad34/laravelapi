<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    public function getIntegration(Request $request){

        return response()->json([
                'status' => 'success',
                'message' => 'Integration saved successfully.',
            ], 200);

    }

    public function addIntegration(Request $request){

        return response()->json([
                'status' => 'success',
                'message' => 'Add Integration saved successfully.',
            ], 200);

    }

    public function getSingleIntegration($id){

        return response()->json([
                'status' => 'success',
                'message' => 'Get Single Integration successfully.',
            ], 200);

    }

    public function updateIntegration(Request $request, $id){

        return response()->json([
                'status' => 'success',
                'message' => 'Update Integration data successfully.',
            ], 200);

    }

    public function DeleteIntegration($id){

        return response()->json([
                'status' => 'success',
                'message' => 'Delete Single Integration data successfully.',
            ], 200);

    }
}
