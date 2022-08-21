<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilitysettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilitysettings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('facilities_id');
            $table->foreign('facilities_id')->references('facilitytypeid')->on('roomfacilitytype');
            $table->double('facilities_price');
            $table->string('facilities_status');
            $table->enum('status',['1','2'])->default('1')->comment="1=active,2=inactive";
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('facilitysettings');
    }
}
