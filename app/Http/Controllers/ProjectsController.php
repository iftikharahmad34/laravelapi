<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function Index(Request $request){

        $projects = Project::latest()->get();
        return response()->json([
            'status' => 'success',
            'projects' => $projects
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

        Project::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Project created successfully.'
        ], 200);
    }

    public function getSingleProjects($id){

        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'project' => $project
        ], 200);

    }

    public function updateProjects(Request $request, $id){

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

        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found.'
            ], 404);
        }

        $project->name = $request->name;
        $project->type = $request->type;
        $project->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Project updated successfully.',
            'project' => $project
        ], 200);
    }

    public function DeleteProjects($id){

        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found.'
            ], 404);
        }

        $project->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Project deleted successfully.'
        ], 200);

    }
}
