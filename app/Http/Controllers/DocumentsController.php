<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Documents;

class DocumentsController extends Controller
{
    public function Index(Request $request){

        $documents = Document::latest()->get();

        return response()->json(['documents' => $documents], 200);

    }

    public function Store(Request $request){

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents', 'public');
        }

        $document = Document::create([
            'name' => $request->name,
            'file' => $path ?? null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Document uploaded successfully.',
            'data' => $document
        ], 201);
    }

    public function getSingleDocuments($id){

        $document = Document::find($id);

        if (!$document) {
            return response()->json(['status' => 'error', 'message' => 'Document not found.'], 404);
        }

        return response()->json(['document' => $document], 200);

    }

    public function updateDocuments(Request $request, $id){

        $document = Document::find($id);

        if (!$document) {
            return response()->json(['status' => 'error', 'message' => 'Document not found.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'file' => 'sometimes|file|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents', 'public');
            $document->file = $path;
        }

        $document->name = $request->name ?? $document->name;
        $document->category = $request->category ?? $document->type;

        $document->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Document updated successfully.',
            'data' => $document
        ], 200);

    }

    public function DeleteDocuments($id){

        $document = Document::find($id);

        if (!$document) {
            return response()->json(['status' => 'error', 'message' => 'Document not found.'], 404);
        }

        $document->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Document deleted successfully.'
        ], 200);
    }
}
