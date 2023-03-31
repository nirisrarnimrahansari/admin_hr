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
        Schema::create('genrate_salaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('leave_type')->nullable();
            $table->string('basic_salary')->nullable();
            $table->string('current_salary')->nullable();
            $table->date('deleted_date')->nullable();
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
        Schema::dropIfExists('genrate_salaries');
    }
};
