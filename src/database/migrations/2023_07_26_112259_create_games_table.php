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
            $table->foreignId('hometeam_id');
            $table->foreignId('awayteam_id');
            $table->integer('hometeam_score')->nullable();
            $table->integer('awayteam_score')->nullable();
            $table->string('winner')->nullable();
            $table->string('status');
            $table->dateTime('kickoff_utc')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
};
