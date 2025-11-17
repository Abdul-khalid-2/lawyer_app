<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('youtube_videos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('lawyer_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('video_topic');
            $table->string('youtube_link');
            $table->string('youtube_video_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('display_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->integer('total_view_time')->default(0); // in seconds
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->json('thumbnail')->nullable();
            $table->integer('duration')->nullable(); // in seconds
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index('lawyer_id');
            $table->index('display_count');
            $table->index('view_count');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index(['lawyer_id', 'is_active']);
        });

        // Bridge table for blog posts and youtube videos
        Schema::create('blog_post_youtube_video', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_post_id')->constrained()->onDelete('cascade');
            $table->foreignId('youtube_video_id')->constrained()->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->unique(['blog_post_id', 'youtube_video_id']);
        });

        // Table for tracking video views and watch time
        Schema::create('video_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('youtube_video_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->integer('watch_time')->default(0); // in seconds
            $table->boolean('completed')->default(false);
            $table->timestamps();

            $table->index('youtube_video_id');
            $table->index('user_id');
            $table->index('ip_address');
            $table->index(['youtube_video_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_views');
        Schema::dropIfExists('blog_post_youtube_video');
        Schema::dropIfExists('youtube_videos');
    }
};
