<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('contact_communications')) {
            return;
        }

        Schema::table('contact_communications', function (Blueprint $table) {
            if (! Schema::hasColumn('contact_communications', 'channel')) {
                $table->string('channel')->default('internal')->after('communication');
            }
            if (! Schema::hasColumn('contact_communications', 'subject')) {
                $table->string('subject')->nullable()->after('channel');
            }
            if (! Schema::hasColumn('contact_communications', 'provider')) {
                $table->string('provider')->nullable()->after('subject');
            }
            if (! Schema::hasColumn('contact_communications', 'provider_message_id')) {
                $table->string('provider_message_id')->nullable()->after('provider');
            }
            if (! Schema::hasColumn('contact_communications', 'status')) {
                $table->string('status')->default('pending')->after('provider_message_id');
            }
            if (! Schema::hasColumn('contact_communications', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('status');
            }
            if (! Schema::hasColumn('contact_communications', 'meta')) {
                $table->json('meta')->nullable()->after('delivered_at');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('contact_communications')) {
            return;
        }

        Schema::table('contact_communications', function (Blueprint $table) {
            foreach (['channel', 'subject', 'provider', 'provider_message_id', 'status', 'delivered_at', 'meta'] as $column) {
                if (Schema::hasColumn('contact_communications', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
