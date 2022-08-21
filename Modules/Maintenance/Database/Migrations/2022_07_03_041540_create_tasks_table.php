<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('emp_his_id')->on('employee_history');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('tasktypes');
            $table->string('task_floor')->nullable();
            $table->string('task_room')->nullable();
            $table->text('description')->nullable();
            $table->string('assign_dt')->nullable();
            $table->string('schedule_dt')->nullable();
            $table->string('assign_hours')->nullable();
            $table->string('before_image')->nullable();
            $table->string('after_image')->nullable();
            $table->string('assign_by')->nullable();
            $table->string('reported_by')->nullable();
            $table->string('completed_dt')->nullable();
            $table->string('command')->nullable();
            $table->string('completed_hours')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
