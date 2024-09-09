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
        Schema::create('eventbasic', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->string('title');
            $table->string('image')->nullable();
            $table->boolean('limit')->default(false);
            $table->integer('limit_number')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('overview_title');
            $table->text('overview_text');
            $table->text('terms');
            $table->text('privacy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventbasic');
    }
};
