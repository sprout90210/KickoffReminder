<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('position');
            $table->unsignedInteger('played_games')->default(0);
            $table->integer('won')->default(0);
            $table->integer('draw')->default(0);
            $table->integer('lost')->default(0);
            $table->integer('goals_for')->default(0);
            $table->integer('goals_against')->default(0);
            $table->integer('goal_difference')->default(0);
            $table->integer('points')->default(0);
            $table->foreignId('team_id')->nullable();
            $table->foreignId('season_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('standings');
    }
};
