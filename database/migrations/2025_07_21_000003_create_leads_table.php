<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('status');
            $table->foreignId('contact_id')->constrained('contacts');
            $table->foreignId('property_id')->nullable()->constrained('properties');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
