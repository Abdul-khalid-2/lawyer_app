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
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('lawyer_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('designation'); // e.g., Associate, Paralegal, Junior Counsel
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->text('qualifications')->nullable();
            $table->integer('years_of_experience')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
