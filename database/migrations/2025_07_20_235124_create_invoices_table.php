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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('number')->unique();
            $table->date('date');
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('unpaid'); // unpaid, paid, overdue
            $table->date('due_date')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
