<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilitydiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilitydiscounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('facilities_member_id');
            $table->foreign('facilities_member_id')->references('card_member_id')->on('cards');
            $table->unsignedBigInteger('facilities_discount_id');
            $table->foreign('facilities_discount_id')->references('facilities_id')->on('facilitysettings');
            $table->double('facilities_discount_price');
            $table->string('facilities_discount_type');
            $table->double('facilities_discount_percentage');
            $table->double('facilities_discount_fixed');
            $table->double('facilities_discount_offer_price');
            $table->date('facilities_discount_start_date')->nullable();
            $table->date('facilities_discount_end_date')->nullable();
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
        Schema::dropIfExists('facilitydiscounts');
    }
}
