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
            $table->foreignId('season_id')->nullable();
            $table->foreignId('home_team_id');
            $table->foreignId('away_team_id');
            $table->integer('home_team_score')->nullable();
            $table->integer('away_team_score')->nullable();
            $table->string('winner')->nullable();
            $table->string('status');
            $table->dateTime('utc_date')->nullable();
            $table->dateTime('last_updated')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
};
