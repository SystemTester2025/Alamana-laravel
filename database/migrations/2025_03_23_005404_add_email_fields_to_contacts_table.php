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
        Schema::table('contacts', function (Blueprint $table) {
            $table->boolean('is_replied')->default(false);
            $table->text('reply_message')->nullable();
            $table->timestamp('reply_date')->nullable();
            $table->string('message_type')->default('incoming'); // 'incoming' or 'outgoing'
            $table->string('status')->default('received'); // 'received', 'sent', 'draft', 'trash'
            $table->json('attachments')->nullable(); // JSON field to store attachment paths
            $table->text('cc')->nullable();
            $table->text('bcc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('is_replied');
            $table->dropColumn('reply_message');
            $table->dropColumn('reply_date');
            $table->dropColumn('message_type');
            $table->dropColumn('status');
            $table->dropColumn('attachments');
            $table->dropColumn('cc');
            $table->dropColumn('bcc');
        });
    }
};
