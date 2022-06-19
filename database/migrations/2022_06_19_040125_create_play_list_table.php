<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('play_list', function (Blueprint $table) {
            $table->id();
            $table->string("song_name");
            $table->string("artist_name");
            $table->string("order"); //---database coming define it string i dont know why !!!!!
            $table->string("video")->nullable();
            $table->string("type");
            $table->string("language");
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
        Schema::dropIfExists('play_list');
    }
};
