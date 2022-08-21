<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('card_id');
            $table->unsignedBigInteger('card_member_id');
            $table->foreign('card_member_id')->references('customerid')->on('customerinfo');
            $table->string('card_facilities_id');
            $table->foreign('card_facilities_id')->references('facilitytypeid')->on('roomfacilitytype');
            $table->double('card_min_value');
            $table->double('card_trash_hold')->nullable();
            $table->string('room_access')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('cards');
    }
}
