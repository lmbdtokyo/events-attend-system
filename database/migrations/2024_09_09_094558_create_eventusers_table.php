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
        Schema::create('eventusers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->string('furigana');
            $table->string('company')->nullable();
            $table->string('division')->nullable();
            $table->string('post')->nullable();
            $table->string('mail');
            $table->string('postal_code')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->string('tel')->nullable();
            $table->date('birth')->nullable();
            $table->string('section')->nullable();
            $table->string('login_id');
            $table->string('password');
            $table->boolean('approval')->default(false);
            $table->string('qr')->nullable();
            $table->string('pdf_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventusers');
    }
};
