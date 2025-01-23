<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_diris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
            $table->string('name');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->date('birth_date');
            $table->string('birth_place');
            $table->string('address');
            $table->string('phone_number');
            $table->string('profile_picture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_diris');
    }
};
