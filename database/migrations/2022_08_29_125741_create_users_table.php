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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile');
            $table->unsignedBigInteger('user_occ')->nullable();
            $table->unsignedBigInteger('user_r')->nullable();
            $table->string('user_image')->nullable();
            $table->string('remember_token')->nullable();
            $table->date('deleted_date')->nullable();
            $table->timestamps();
            $table->foreign('user_occ')->references('id')->on('designations')->onDelete('SET NULL');
            $table->foreign('user_r')->references('id')->on('user_roles')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
