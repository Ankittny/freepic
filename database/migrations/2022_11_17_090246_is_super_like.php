<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IsSuperLike extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('lssuperlike',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('userid');
            $table->string('likes')->default('0');
            $table->string('counts')->defaul('0');
            $table->string('SuperLike')->default('false');
            $table->rememberToken();
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
        Schemma::dropIfExists('lssuperlike');
    }
}
