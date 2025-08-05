<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "equiptment";

    public function document(){
        return $this->belongsTo(EquipmentDocument::class, 'id', 'equipment_id');
    }

}
