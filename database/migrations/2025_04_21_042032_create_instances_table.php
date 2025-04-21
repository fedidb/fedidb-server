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
        Schema::create('instances', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable()->index();
            $table->string('domain')->unique()->index();
            $table->string('base_domain')->nullable()->index();
            $table->string('software')->nullable()->index();
            $table->string('version')->nullable();
            $table->json('nodeinfo')->nullable();
            $table->json('instance_data')->nullable();
            $table->json('metadata')->nullable();
            $table->unsignedInteger('status_count')->nullable()->index();
            $table->unsignedInteger('user_count')->nullable()->index();
            $table->unsignedInteger('daily_active')->nullable();
            $table->unsignedInteger('monthly_active')->nullable()->index();
            $table->unsignedInteger('quarter_active')->nullable();
            $table->boolean('active')->default(false)->index();
            $table->timestamp('first_seen_at')->nullable();
            $table->timestamp('last_seen_at')->nullable()->index();
            $table->string('favicon')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable()->index();
            $table->string('asn_org')->nullable();
            $table->boolean('is_banned')->nullable()->index();
            $table->string('ban_reason')->nullable();
            $table->boolean('skip_crawling')->nullable()->index();
            $table->boolean('is_hidden')->default(false)->index();
            $table->timestamp('hidden_at')->nullable();
            $table->string('hidden_reason')->nullable();
            $table->tinyInteger('crawl_state')->default(0)->index();
            $table->tinyInteger('blocked_by_robots')->default(0)->index();
            $table->timestamp('robots_last_checked')->nullable();
            $table->timestamp('ip_last_checked_at')->nullable();
            $table->timestamp('instance_data_fetched_at')->nullable()->index();
            $table->timestamp('thumbnail_last_fetched_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instances');
    }
};
