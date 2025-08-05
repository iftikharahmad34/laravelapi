<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "vehicles";

    public function vehicle(){
        return $this->belongsTo(VehicleDocument::class, 'id', 'vehicle_id');
    }
}
