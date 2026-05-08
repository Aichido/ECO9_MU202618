<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->uuid('formation_id');
            $table->uuid('user_id');
            $table->tinyInteger('note')->unsigned(); // 1..5
            $table->text('commentaire')->nullable();
            $table->timestamps();

            $table->unique(['formation_id', 'user_id']);
            $table->index('formation_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
};