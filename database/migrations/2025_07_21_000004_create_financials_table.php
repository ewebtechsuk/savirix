<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financials', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->decimal('amount', 12, 2);
            $table->date('date');
            $table->string('description')->nullable();
            $table->foreignId('property_id')->nullable()->constrained('properties');
            $table->foreignId('tenancy_id')->nullable()->constrained('tenancies');
            $table->foreignId('contact_id')->nullable()->constrained('contacts');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('financials');
    }
};
