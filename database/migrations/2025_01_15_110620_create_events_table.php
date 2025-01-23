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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('location');
            $table->string('location_url');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('max_person')->default('9999');
            $table->string('institution');
            $table->string('pic')->nullable();
            $table->string('email')->nullable();
            $table->enum('status', ['draft', 'submission', 'preparation', 'registration', 'on-going', 'done'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
