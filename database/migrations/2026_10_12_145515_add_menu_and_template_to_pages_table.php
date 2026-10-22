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
        Schema::table('pages', function (Blueprint $table) {
            $table->string('menu_location', 50)->nullable()->after('is_active'); // ministry, offerings, documents, media, connect, top, none
            $table->integer('sort_order')->default(0)->after('menu_location');
            $table->string('template_type', 50)->default('standard')->after('sort_order'); // standard, table, directory, officers, downloads
            $table->text('meta_description')->nullable()->after('template_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['menu_location', 'sort_order', 'template_type', 'meta_description']);
        });
    }
};
