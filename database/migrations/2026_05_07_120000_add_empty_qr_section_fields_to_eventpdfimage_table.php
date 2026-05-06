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
        Schema::table('eventpdfimage', function (Blueprint $table) {
            $table->string('empty_qr_section_label', 100)->nullable()->default('受付区分名');
            $table->string('empty_qr_section_bg_color', 7)->nullable()->default('#ff0000');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventpdfimage', function (Blueprint $table) {
            $table->dropColumn([
                'empty_qr_section_label',
                'empty_qr_section_bg_color',
            ]);
        });
    }
};
