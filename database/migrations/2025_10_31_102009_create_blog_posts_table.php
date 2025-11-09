<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->json('heading')->nullable();
            $table->foreignId('lawyer_id')->constrained()->onDelete('cascade');
            $table->foreignId('blog_category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique();
            $table->json('structure')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->json('tags')->nullable();
            $table->integer('view_count')->default(0);
            $table->integer('read_time')->default(5);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->enum('is_featured', ['1', '0'])->default('0');
            $table->timestamp('published_at')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // Canvas elements for flexible content
            $table->json('banner')->nullable();
            $table->json('image')->nullable();
            $table->json('rich_text')->nullable();
            $table->json('text_left_image_right')->nullable();
            $table->json('custom_html')->nullable();
            $table->json('canvas_elements')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
