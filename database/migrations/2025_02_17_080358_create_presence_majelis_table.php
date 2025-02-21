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
        Schema::create('presence_majelis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('majelis_id')->nullable();
            $table->foreign('majelis_id')->references('id')->on('majelis')->onDelete('cascade');
            $table->foreignId('user_id_presenced');
            $table->foreign('user_id_presenced')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('user_id_presencer')->nullable();
            $table->foreign('user_id_presencer')->references('id')->on('users')->onDelete('cascade');
            $table->string('proof_pic')->nullable();
            $table->string('status');
            $table->text('desc')->nullable();
            $table->text('resume')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presence_majelis');
    }
};
