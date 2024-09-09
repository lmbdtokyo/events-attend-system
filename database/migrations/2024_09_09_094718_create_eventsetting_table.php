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
            $table->boolean('name_required_flg')->default(false);
            $table->string('name_placeholder')->nullable();
            $table->string('furigana_display_name');
            $table->boolean('furigana_flg')->default(true);
            $table->boolean('furigana_required_flg')->default(false);
            $table->string('furigana_placeholder')->nullable();
            $table->string('company_display_name');
            $table->boolean('company_flg')->default(true);
            $table->boolean('company_required_flg')->default(false);
            $table->string('company_placeholder')->nullable();
            $table->string('division_display_name');
            $table->boolean('division_flg')->default(true);
            $table->boolean('division_required_flg')->default(false);
            $table->string('division_placeholder')->nullable();
            $table->string('post_display_name');
            $table->boolean('post_flg')->default(true);
            $table->boolean('post_required_flg')->default(false);
            $table->string('post_placeholder')->nullable();
            $table->string('postal_code_display_name');
            $table->boolean('postal_code_flg')->default(true);
            $table->boolean('postal_code_required_flg')->default(false);
            $table->string('postal_code_placeholder')->nullable();
            $table->string('address1_display_name');
            $table->boolean('address1_flg')->default(true);
            $table->boolean('address1_required_flg')->default(false);
            $table->string('address1_placeholder')->nullable();
            $table->string('address2_display_name');
            $table->boolean('address2_flg')->default(true);
            $table->boolean('address2_required_flg')->default(false);
            $table->string('address2_placeholder')->nullable();
            $table->string('address3_display_name');
            $table->boolean('address3_flg')->default(true);
            $table->boolean('address3_required_flg')->default(false);
            $table->string('address3_placeholder')->nullable();
            $table->string('tel_display_name');
            $table->boolean('tel_flg')->default(true);
            $table->boolean('tel_required_flg')->default(false);
            $table->string('tel_placeholder')->nullable();
            $table->string('birth_display_name');
            $table->boolean('birth_flg')->default(true);
            $table->boolean('birth_required_flg')->default(false);
            $table->string('birth_placeholder')->nullable();
            $table->string('section_display_name');
            $table->boolean('section_flg')->default(true);
            $table->boolean('section_required_flg')->default(false);
            $table->string('section_placeholder')->nullable();
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
