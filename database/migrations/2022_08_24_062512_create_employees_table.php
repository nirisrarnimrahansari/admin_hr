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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('father_name');
            $table->string('select_id');
            $table->string('id_proof');
            $table->string('upload_pan_card');
            $table->string('pan_number');
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->string('email_id');
            $table->bigInteger('whatsapp_no');
            $table->date('dob');
            $table->date('joining_date');
            $table->bigInteger('basic_salary');
            $table->date('basic_salary_ed')->nullable();
            $table->unsignedBigInteger('shift_id')->nullable();
            $table->date('shift_ed')->nullable();
            $table->string('type');
            $table->date('permanent_date')->nullable();
            $table->integer('casual_leave')->nullable();
            $table->integer('earn_leave')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->bigInteger('biometric_id');
            $table->date('deleted_date')->nullable();
            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('SET NULL');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('SET NULL');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
