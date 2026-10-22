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
        Schema::table('whats_news', function (Blueprint $table) {
            $table->string('category')->nullable()->default('Update')->after('title_en');
            $table->string('file_size')->nullable()->after('document_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whats_news', function (Blueprint $table) {
            $table->dropColumn(['category', 'file_size']);
        });
    }
};
