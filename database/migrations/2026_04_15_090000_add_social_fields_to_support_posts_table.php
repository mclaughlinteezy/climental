<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('support_posts', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('content');
            $table->foreignId('repost_of_id')
                ->nullable()
                ->after('image_path')
                ->constrained('support_posts')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('support_posts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('repost_of_id');
            $table->dropColumn('image_path');
        });
    }
};
