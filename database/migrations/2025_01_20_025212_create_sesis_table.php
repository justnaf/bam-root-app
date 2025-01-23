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
        Schema::create('sesis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->string('name');
            $table->string('speaker');
            $table->string('time');
            $table->string('room');
            $table->string('type');
            $table->boolean('grade');
            $table->string('cv_path')->nullable();
            $table->string('materi_path')->nullable();
            $table->enum('status', ['inactive', 'active', 'gradding', 'done'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesis');
    }
};
