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
        Schema::create('translations', function (Blueprint $table) {
                $table->id();  // bigint unsigned
                $table->string('token', 255)->nullable()->unique();
                $table->string('key');
                $table->unsignedBigInteger('translatable_id')->nullable();
                $table->unsignedBigInteger('language_id')->nullable();
                $table->string('translatable_type');
                $table->text('value');
                $table->enum('status', ['1', '0'])->default('0');  // No issue here
                $table->timestamps();
            
                // Foreign key definition
                $table->foreign('language_id')
                      ->references('id')
                      ->on('languages')
                      ->onDelete('cascade');
            });
            
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
