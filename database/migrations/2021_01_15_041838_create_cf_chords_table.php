<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCfChordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cf_chords', function (Blueprint $table) {
            $table->increments('chord_id');
            $table->string('title', 255);
            $table->string('author', 255);
            $table->longText('chords');
            $table->boolean('is_original')->default(0);
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
        Schema::dropIfExists('cf_chords');
    }
}
