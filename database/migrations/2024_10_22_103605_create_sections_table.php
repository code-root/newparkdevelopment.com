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
            Schema::create('sections', function (Blueprint $table) {
                $table->id();   
                $table->string('name_ar');
                $table->string('name_en');
                $table->string('slug')->nullable();
                $table->string('description_ar')->nullable();
                $table->string('description_en')->nullable();
                $table->string('image')->nullable();
                $table->boolean('status')->default(1);
                $table->unsignedBigInteger('section_id')->nullable()->default(0); // إضافة الحقل الجديد
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
