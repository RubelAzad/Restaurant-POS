<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaddonassignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raddonassigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fooditem_id')->nullable();
            $table->foreign('fooditem_id')->references('id')->on('ritems');
            $table->unsignedBigInteger('addon_id')->nullable();
            $table->foreign('addon_id')->references('id')->on('raddons');
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
        Schema::dropIfExists('raddonassigns');
    }
}
