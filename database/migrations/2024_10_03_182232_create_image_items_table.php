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
        Schema::create('image_items', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('original_name');
            $table->string('table_name');
            $table->unsignedBigInteger('table_id');
            $table->string('type');
            $table->string('status');
            $table->string('token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_items');
    }
};
