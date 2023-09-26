<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('current_season_id')->nullable();
            $table->string('name');
            $table->string('code');
            $table->string('competition_type');
            $table->string('emblem')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('competitions');
    }
};
