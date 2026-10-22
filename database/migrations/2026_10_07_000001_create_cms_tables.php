<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add role and status to users table if not already added
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 50)->default('editor')->after('email');
                $table->boolean('is_active')->default(true)->after('role');
            });
        }

        // 1. Activity Logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_name', 100)->nullable();
            $table->string('action', 50); // login, logout, create, update, delete
            $table->string('module', 50); // banners, schemes, documents, etc.
            $table->unsignedBigInteger('record_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
        });

        // 2. Banners / Sliders
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title_hi');
            $table->string('title_en')->nullable();
            $table->string('subtitle_hi')->nullable();
            $table->string('subtitle_en')->nullable();
            $table->string('image_url');
            $table->string('link_url')->nullable();
            $table->string('link_text_hi')->nullable()->default('अधिक विवरण');
            $table->string('link_text_en')->nullable()->default('Read More');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Announcements / Tickers
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->text('title_hi');
            $table->text('title_en')->nullable();
            $table->string('link_url')->nullable();
            $table->boolean('is_new')->default(true);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Dignitaries / Ministers
        Schema::create('dignitaries', function (Blueprint $table) {
            $table->id();
            $table->string('name_hi');
            $table->string('name_en');
            $table->string('designation_hi');
            $table->string('designation_en');
            $table->string('type', 50)->default('minister'); // prime_minister, minister, secretary, official
            $table->string('photo_url')->nullable();
            $table->text('quote_hi')->nullable();
            $table->text('quote_en')->nullable();
            $table->string('quote_date')->nullable();
            $table->string('profile_link')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Schemes & Services
        Schema::create('schemes', function (Blueprint $table) {
            $table->id();
            $table->string('title_hi');
            $table->string('title_en')->nullable();
            $table->text('description_hi')->nullable();
            $table->text('description_en')->nullable();
            $table->string('category', 50)->default('scheme'); // scheme, service, initiative
            $table->string('link_url')->nullable();
            $table->string('guidelines_doc')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 6. Tenders & Vacancies
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->nullable();
            $table->string('title_hi');
            $table->string('title_en')->nullable();
            $table->string('type', 50)->default('tender'); // tender, vacancy, rfp
            $table->date('published_date')->nullable();
            $table->date('closing_date')->nullable();
            $table->string('document_url')->nullable();
            $table->string('status', 30)->default('open'); // open, closed, archived
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 7. What's New items
        Schema::create('whats_news', function (Blueprint $table) {
            $table->id();
            $table->text('title_hi');
            $table->text('title_en')->nullable();
            $table->text('content_hi')->nullable();
            $table->text('content_en')->nullable();
            $table->date('date')->nullable();
            $table->string('link_url')->nullable();
            $table->string('document_url')->nullable();
            $table->boolean('is_new')->default(true);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 8. Documents & Publications
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title_hi');
            $table->string('title_en')->nullable();
            $table->string('category', 50)->default('gazette'); // gazette, report, policy, circular
            $table->text('description_hi')->nullable();
            $table->text('description_en')->nullable();
            $table->string('file_url')->nullable();
            $table->string('file_size', 20)->nullable();
            $table->date('published_date')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 9. User Personas
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('title_hi');
            $table->string('title_en')->nullable();
            $table->string('subtitle_hi')->nullable();
            $table->string('subtitle_en')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('link_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 10. Important Links
        Schema::create('important_links', function (Blueprint $table) {
            $table->id();
            $table->string('title_hi');
            $table->string('title_en')->nullable();
            $table->string('url');
            $table->string('target', 20)->default('_blank');
            $table->string('category', 50)->default('important'); // important, quick, footer
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 11. Campaigns & Banners (Make In India, BRICS, Dashboard, etc.)
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title_hi');
            $table->string('title_en')->nullable();
            $table->string('image_url');
            $table->string('link_url')->nullable();
            $table->string('type', 50)->default('banner'); // banner, partner_logo, widget
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 12. Feedback / Inquiries
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20)->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('status', 30)->default('new'); // new, read, replied
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        // 13. CMS Pages
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('title_hi');
            $table->string('title_en')->nullable();
            $table->longText('content_hi')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('banner_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 14. Site Settings
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->string('type', 30)->default('text'); // text, textarea, boolean, image
            $table->string('group', 50)->default('general'); // general, header, footer, contact, social
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('inquiries');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('important_links');
        Schema::dropIfExists('personas');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('whats_news');
        Schema::dropIfExists('tenders');
        Schema::dropIfExists('schemes');
        Schema::dropIfExists('dignitaries');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('activity_logs');
    }
};
