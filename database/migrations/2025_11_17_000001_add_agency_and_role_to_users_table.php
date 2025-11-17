<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->unsignedBigInteger('agency_id')->nullable()->after('id');
            $table->string('role')->default('agent')->after('email');

            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropForeign(['agency_id']);
            $table->dropColumn(['agency_id', 'role']);
        });
    }
};
