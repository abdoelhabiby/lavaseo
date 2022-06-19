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
        Schema::create('photography', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->bigInteger("mobile");
            $table->float("price");
            $table->string("address");
            $table->string("email");
            $table->string("photo");
            $table->string("vr_video")->nullable();
            $table->string("package");
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
        Schema::dropIfExists('photography');
    }
};
