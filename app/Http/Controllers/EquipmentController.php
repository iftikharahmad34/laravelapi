<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EquipmentDocument;

class EquipmentController extends Controller
{    
    public function Index(Request $request){

        // $getequipment = Equipment::with('document')->get();

        $getequipment = Equipment::latest()->get(); // fix typo 'lastest' → 'latest'

        foreach ($getequipment as $equipment) {
            $alldocument = EquipmentDocument::where('equipment_id', $equipment->id)->get();

            foreach ($alldocument as $index => $doc) {
                $propertyName = 'document' . ($index + 1);
                $equipment->$propertyName = $doc->file;
            }
        }
        return response()->json(['equipment' => $getequipment]);

    }
    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422); 
        }
        
        $equipment = Equipment::create([
            'name' => $request->name,
            'model' => $request->model,
            'serial' =>$request->serial,
            'plateNumber' => $request->plateNumber, 
            'registrationExpiry' => $request->registrationExpiry,
            'insuranceExpiry' => $request->insuranceExpiry,
            'thirdPartyExpiry' => $request->thirdPartyExpiry,
            'category' => $request->category,
            'description' => $request->description,
            'status' => $request->status,
            'purchaseDate' => $request->purchaseDate,
            'purchasePrice' => $request->purchasePrice,
            'manufacturer' => $request->manufacturer,
            'yearOfManufacture' => $request->yearOfManufacture,
            'operatingHours' => $request->operatingHours,
            'fuelType' => $request->fuelType,
            'location' => $request->location,
            'assignedOperator' => $request->assignedOperator,
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/Equipment_document'), $fileName);

                $fileLink = 'https://laravel.mysignages.com/assets/Equipment_document/' . $fileName;

                EquipmentDocument::create([
                    'equipment_id' => $equipment->id,
                    'file' => $fileLink,
                ]);

                
            }
             return response()->json([
                'status' => 'success',
                'message' => 'document saved successfully.',
                'id' => $equipment->id
            ], 200);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'document not saved successfully.',
                'id' => ''
            ], 200);
        }

    }
    public function getSingleEquipment($id){

        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json(['message' => 'Equipment not found'], 404);
        }

        $documents = EquipmentDocument::where('equipment_id', $id)->get();

        $equipment->documents = $documents;

        return response()->json($equipment);
        
    }
    
    public function updateEquipment(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json(['message' => 'Equipment not found'], 404);
        }

        $equipment->name = $request->name;
        $equipment->model = $request->model;
        $equipment->serial = $request->serial;
        $equipment->plateNumber = $request->plateNumber;
        $equipment->registrationExpiry = $request->registrationExpiry;
        $equipment->insuranceExpiry = $request->insuranceExpiry;
        $equipment->thirdPartyExpiry = $request->thirdPartyExpiry;
        $equipment->category = $request->category;
        $equipment->description = $request->description;
        $equipment->status = $request->status;
        $equipment->purchaseDate = $request->purchaseDate;
        $equipment->purchasePrice = $request->purchasePrice;
        $equipment->manufacturer = $request->manufacturer;
        $equipment->yearOfManufacture = $request->yearOfManufacture;
        $equipment->operatingHours = $request->operatingHours;
        $equipment->fuelType = $request->fuelType;
        $equipment->location = $request->location;
        $equipment->assignedOperator = $request->assignedOperator;
        $equipment->save();

        if ($request->has('documents')) {
            EquipmentDocument::where('equipment_id', $id)->delete();

            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/Equipment_document'), $fileName);

                $fileLink = 'https://laravel.mysignages.com/assets/Equipment_document/' . $fileName;

                EquipmentDocument::create([
                    'equipment_id' => $id,
                    'file' => $fileLink,
                ]);
            }
        }

        $equipment->documents = EquipmentDocument::where('equipment_id', $id)->get();

        return response()->json($equipment);
    }
    
    public function DeleteEquipment($id){
       EquipmentDocument::where('equipment_id', $id)->delete();

        Equipment::find($id)->delete();

        return response()->json(['message' => 'Equipment and related documents deleted successfully']);
    }
}
