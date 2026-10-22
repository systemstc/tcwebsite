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
        Schema::create('site_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 80)->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->string('url', 190)->index();
            $table->string('path', 190)->index();
            $table->string('page_title', 190)->nullable();
            $table->string('locale', 15)->default('en')->index();
            $table->string('bhashini_lang', 20)->nullable()->index();
            $table->boolean('is_bhashini')->default(false)->index();
            $table->string('device_type', 20)->default('Desktop')->index(); // Desktop, Mobile, Tablet
            $table->string('browser', 40)->nullable()->index();
            $table->string('platform', 40)->nullable();
            $table->string('referer', 190)->nullable();
            $table->date('view_date')->index();
            $table->timestamps();

            $table->index(['view_date', 'path']);
            $table->index(['view_date', 'locale']);
            $table->index(['view_date', 'bhashini_lang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_analytics');
    }
};
