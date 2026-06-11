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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lawyer_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['hearing', 'meeting', 'consultation', 'personal'])->default('meeting');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('location')->nullable();
            $table->foreignId('case_id')->nullable()->constrained('legal_cases')->nullOnDelete();
            $table->boolean('is_public')->default(false); // visible on public profile as availability
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
