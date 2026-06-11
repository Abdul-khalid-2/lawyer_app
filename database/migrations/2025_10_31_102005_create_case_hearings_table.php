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
        Schema::create('case_hearings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('legal_cases')->onDelete('cascade');
            $table->date('hearing_date');
            $table->time('hearing_time')->nullable();
            $table->string('court_name')->nullable();
            $table->string('room')->nullable();
            $table->string('purpose')->nullable();
            $table->text('outcome')->nullable(); // filled after hearing
            $table->enum('status', ['scheduled', 'completed', 'adjourned', 'cancelled'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_hearings');
    }
};
