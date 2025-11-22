<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tenancies')) {
            // Table already exists (e.g. production), skip creating it again.
            return;
        }

        Schema::create('tenancies', function (Blueprint $table) {
            $table->id();

            // Keep proper foreign keys + indexes
            $table->foreignId('property_id')->constrained('properties');
            $table->foreignId('contact_id')->constrained('contacts');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('rent', 12, 2);
            $table->string('status');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenancies');
    }
};
