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
        Schema::create('eventprogress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->boolean('form_basic_flg')->default(false);
            $table->boolean('form_setting_flg')->default(false);
            $table->boolean('mypage_basic_flg')->default(false);
            $table->boolean('finish_mail_flg')->default(false);
            $table->boolean('entry_mail_flg')->default(false);
            $table->boolean('exit_mail_flg')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventprogress');
    }
};
