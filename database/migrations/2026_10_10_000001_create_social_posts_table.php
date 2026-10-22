<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_posts', function (Blueprint $table) {
            $table->id();
            $table->string('platform', 30); // twitter, youtube, facebook, instagram
            $table->text('post_url'); // The link to the tweet/video/post
            $table->string('title')->nullable(); // Video title or headline
            $table->text('content')->nullable(); // Tweet/post caption or text
            $table->string('media_image')->nullable(); // Image or video thumbnail path/URL
            $table->string('author_name')->nullable()->default('Ministry of Textiles');
            $table->string('author_handle')->nullable()->default('@TexMinIndia');
            $table->string('post_date')->nullable();
            $table->string('likes_count')->nullable()->default('142');
            $table->string('comments_count')->nullable()->default('18');
            $table->string('shares_count')->nullable()->default('24');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_posts');
    }
};
