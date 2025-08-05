<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicles;
use App\Models\VehicleDocument;

class VehiclesController extends Controller
{
    public function Index(Request $request){

       $vehicles = Vehicles::latest()->get();

       if ($vehicles->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No vehicles found.'
            ], 404);
        }

        foreach ($vehicles as $vehicle) {
            $alldocument = VehicleDocument::where('vehicle_id', $vehicle->id)->get();

            foreach ($alldocument as $index => $doc) {
                $propertyName = 'document' . ($index + 1);
                $equipment->$propertyName = $doc->file;
            }
        }
        return response()->json(['vehicles' => $vehicles]);

    }

    public function store(Request $request){

        $vehicles = Vehicles::create([
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

                VehicleDocument::create([
                    'vehicle_id' => $vehicles->id,
                    'file' => $fileLink,
                ]);

                
            }
             return response()->json([
                'status' => 'success',
                'message' => 'document saved successfully.',
                'id' => $vehicles->id
            ], 200);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'document not saved successfully.',
                'id' => ''
            ], 500);
        }

    }

    public function getSingleVehicles($id){

        $vehicles = Vehicles::find($id);

        if (!$vehicles) {
            return response()->json(['message' => 'vehicles not found'], 404);
        }

        $documents = VehicleDocument::where('vehicle_id', $id)->get();

        $vehicles->documents = $documents;

        return response()->json($vehicles);

    }

    public function updateVehicles(Request $request, $id){

        $vehicles = Vehicles::find($id);

        if (!$vehicles) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        $vehicles->name = $request->name;
        $vehicles->model = $request->model;
        $vehicles->serial = $request->serial;
        $vehicles->plateNumber = $request->plateNumber;
        $vehicles->registrationExpiry = $request->registrationExpiry;
        $vehicles->insuranceExpiry = $request->insuranceExpiry;
        $vehicles->thirdPartyExpiry = $request->thirdPartyExpiry;
        $vehicles->category = $request->category;
        $vehicles->description = $request->description;
        $vehicles->status = $request->status;
        $vehicles->purchaseDate = $request->purchaseDate;
        $vehicles->purchasePrice = $request->purchasePrice;
        $vehicles->manufacturer = $request->manufacturer;
        $vehicles->yearOfManufacture = $request->yearOfManufacture;
        $vehicles->operatingHours = $request->operatingHours;
        $vehicles->fuelType = $request->fuelType;
        $vehicles->location = $request->location;
        $vehicles->assignedOperator = $request->assignedOperator;
        $vehicles->save();

        if ($request->has('documents')) {
            VehicleDocument::where('vehicle_id', $id)->delete();

            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/Equipment_document'), $fileName);

                $fileLink = 'https://laravel.mysignages.com/assets/Equipment_document/' . $fileName;

                VehicleDocument::create([
                    'equipment_id' => $id,
                    'file' => $fileLink,
                ]);
            }
        }

        $vehicles->documents = VehicleDocument::where('vehicle_id', $id)->get();

        return response()->json($vehicles);

    }

    public function DeleteVehicles($id){

        VehicleDocument::where('vehicle_id', $id)->delete();

        Vehicles::find($id)->delete();

        return response()->json(['message' => 'Vehicles and related documents deleted successfully'], 200);

    }
}
