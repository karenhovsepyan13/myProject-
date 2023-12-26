<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTictactoeGamesTable extends Migration
{
public function up()
{
Schema::create('tictactoe_games', function (Blueprint $table) {
$table->id();
$table->string('player_1');
$table->string('player_2');
$table->string('values');
$table->string('current_player');
$table->integer('row');
$table->integer('col');
$table->timestamps();
});
}

public function down()
{
Schema::dropIfExists('tictactoe_games');
}
}
