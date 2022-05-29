<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ritems', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('rcat_id');
            $table->foreign('rcat_id')->references('p_id')->on('rcategories');
            $table->string('components')->nullable();
            $table->string('notes')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('tax')->nullable();
            $table->double('qty')->nullable();
            $table->double('alert_qty')->nullable();
            $table->string('offer')->nullable();
            $table->string('special')->nullable();
            $table->double('price');
            $table->double('op_rate')->nullable();
            $table->date('os_date')->nullable();
            $table->date('oe_date')->nullable();
            $table->string('oc_time')->nullable();
            $table->string('ri_menu');
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
        Schema::dropIfExists('ritems');
    }
}
