<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudeFriendShipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitude_friend_ships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("emisor_id");
            $table->unsignedBigInteger("receptor_id");
            $table->boolean('status', false);

            $table->foreign('emisor_id')->references('id')->on('users');
            $table->foreign('receptor_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitude_friend_ships');
    }
}
