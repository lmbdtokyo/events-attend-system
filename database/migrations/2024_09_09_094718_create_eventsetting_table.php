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
        Schema::create('eventsetting', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->string('name_display_name');
            $table->boolean('name_flg')->default(true);
            $table->string('name_placeholder')->nullable();
            $table->string('furigana_display_name');
            $table->boolean('furigana_flg')->default(true);
            $table->string('furigana_placeholder')->nullable();
            $table->string('company_display_name');
            $table->boolean('company_flg')->default(true);
            $table->string('company_placeholder')->nullable();
            $table->string('division_display_name');
            $table->boolean('division_flg')->default(true);
            $table->string('division_placeholder')->nullable();
            $table->string('post_display_name');
            $table->boolean('post_flg')->default(true);
            $table->string('post_placeholder')->nullable();
            $table->string('postal_code_display_name');
            $table->boolean('postal_code_flg')->default(true);
            $table->string('postal_code_placeholder')->nullable();
            $table->string('address1_display_name');
            $table->boolean('address1_code_flg')->default(true);
            $table->string('address1_code_placeholder')->nullable();
            $table->string('address2_display_name');
            $table->boolean('address2_code_flg')->default(true);
            $table->string('address2_code_placeholder')->nullable();
            $table->string('address3_display_name');
            $table->boolean('address3_code_flg')->default(true);
            $table->string('address3_code_placeholder')->nullable();
            $table->string('tel_display_name');
            $table->boolean('tel_code_flg')->default(true);
            $table->string('tel_code_placeholder')->nullable();
            $table->string('birth_display_name');
            $table->boolean('birth_code_flg')->default(true);
            $table->string('birth_code_placeholder')->nullable();
            $table->string('section_display_name');
            $table->boolean('section_code_flg')->default(true);
            $table->string('section_code_placeholder')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventsetting');
    }
};
