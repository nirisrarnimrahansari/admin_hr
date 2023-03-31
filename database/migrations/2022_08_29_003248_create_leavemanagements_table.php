<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('leave_type')->nullable();
            $table->date('leave_date');
            $table->date('deleted_date')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('SET NULL');
            $table->foreign('leave_type')->references('id')->on('leave_statuses')->onDelete('SET NULL');
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
        Schema::dropIfExists('leave_management');
    }
};
