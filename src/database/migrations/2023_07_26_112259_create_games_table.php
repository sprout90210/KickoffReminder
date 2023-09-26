<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id');
            $table->foreignId('home_team_id')->nullable();
            $table->foreignId('away_team_id')->nullable();
            $table->unsignedInteger('home_team_score')->nullable();
            $table->unsignedInteger('away_team_score')->nullable();
            $table->string('winner')->nullable();
            $table->string('status');
            $table->dateTime('utc_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
};
