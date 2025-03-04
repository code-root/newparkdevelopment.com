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
        Schema::create('device_users', function (Blueprint $table) {
            $table->id();
            $table->string('device_type')->nullable();
            $table->string('device_token')->unique();
            $table->string('device_name')->nullable();
            $table->string('device_os')->nullable();
            $table->string('device_version')->nullable();
            $table->string('device_browser')->nullable();
            $table->string('device_browser_version')->nullable();
            $table->string('device_ip')->nullable();
            $table->boolean('is_mobile')->default(false);
            $table->boolean('is_tablet')->default(false);
            $table->boolean('is_desktop')->default(false);
            $table->boolean('is_bot')->default(false);
            $table->foreignId('request_id')->nullable()->constrained('project_requests')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_users');
    }
};
