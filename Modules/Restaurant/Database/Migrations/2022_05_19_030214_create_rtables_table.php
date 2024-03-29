<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRtablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rtables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('capacity');
            $table->string('min_capacity');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('floor_id');
            $table->foreign('floor_id')->references('id')->on('rfloors');
            $table->string('booking_status');
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
        Schema::dropIfExists('rtables');
    }
}
