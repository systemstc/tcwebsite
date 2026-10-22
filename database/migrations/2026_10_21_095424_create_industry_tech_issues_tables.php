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
        Schema::create('industry_tech_issues', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category', 100)->default('General');
            $table->string('urgency', 50)->default('Medium'); // Low, Medium, High, Critical
            $table->string('status', 50)->default('open'); // open, in_progress, solved, closed
            $table->string('industry_name');
            $table->string('contact_person');
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->text('description');
            $table->longText('solution')->nullable();
            $table->timestamp('solution_provided_at')->nullable();
            $table->string('solution_by')->nullable();
            $table->string('tags')->nullable();
            $table->unsignedInteger('upvotes_count')->default(0);
            $table->unsignedInteger('replies_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('industry_tech_issue_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_id')->constrained('industry_tech_issues')->cascadeOnDelete();
            $table->string('name');
            $table->string('industry')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->text('message');
            $table->boolean('is_official')->default(false);
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });

        Schema::create('industry_tech_issue_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_id')->constrained('industry_tech_issues')->cascadeOnDelete();
            $table->string('ip_address', 45);
            $table->string('session_id', 100)->nullable();
            $table->timestamps();

            $table->unique(['issue_id', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industry_tech_issue_votes');
        Schema::dropIfExists('industry_tech_issue_replies');
        Schema::dropIfExists('industry_tech_issues');
    }
};
