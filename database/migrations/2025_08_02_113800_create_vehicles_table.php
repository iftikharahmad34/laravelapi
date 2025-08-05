<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('model')->nullable();
            $table->string('serial')->nullable();
            $table->string('plateNumber')->nullable();
            $table->string('registrationExpiry')->nullable();
            $table->string('insuranceExpiry')->nullable();
            $table->string('thirdPartyExpiry')->nullable();
            $table->string('category')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->string('purchaseDate')->nullable();
            $table->string('purchasePrice')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('yearOfManufacture')->nullable();
            $table->string('operatingHours')->nullable();
            $table->string('fuelType')->nullable();
            $table->string('location')->nullable();
            $table->string('assignedOperator')->nullable();
            $table->string('files')->nullable();
            $table->string('documentSectionsJson')->nullable();
            $table->string('documents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
