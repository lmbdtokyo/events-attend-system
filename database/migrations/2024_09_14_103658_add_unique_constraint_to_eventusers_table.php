<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('eventusers', function (Blueprint $table) {
            $table->unique(['event_id', 'mail']);
        });
    }

    public function down()
    {
        Schema::table('eventusers', function (Blueprint $table) {
            $table->dropUnique(['event_id', 'mail']);
        });
    }
};
