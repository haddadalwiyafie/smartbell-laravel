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
        Schema::create('bell_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->time('time');
            $table->enum('meridiem', ['AM', 'PM']);
            $table->json('days');
            $table->string('audio_file');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bell_schedules');
    }
};
