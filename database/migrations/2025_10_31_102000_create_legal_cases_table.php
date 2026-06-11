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
        Schema::create('legal_cases', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('lawyer_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('team_member_id')->nullable()->constrained()->nullOnDelete(); // assigned member
            $table->string('case_number')->nullable();
            $table->string('title');
            $table->enum('type', ['civil', 'criminal', 'family', 'corporate', 'tax'])->default('civil');
            $table->string('court_name')->nullable();
            $table->string('judge_name')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'active', 'on_hold', 'won', 'lost', 'closed'])->default('pending');
            $table->date('filed_date')->nullable();
            $table->date('next_hearing_date')->nullable();
            $table->boolean('is_visible_to_client')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_cases');
    }
};
