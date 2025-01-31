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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreignId('sesi_id');
            $table->foreign('sesi_id')->references('id')->on('sesis')->onDelete('cascade');
            $table->integer('poin_1')->default(3);
            $table->integer('poin_2')->default(3);
            $table->integer('poin_3')->default(3);
            $table->integer('poin_4')->default(3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
