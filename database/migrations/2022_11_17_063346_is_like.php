<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IsLike extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('islike',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('userid');
            $table->string('like')->default('0');
            $table->string('count')->defaul('0');
            $table->string('isLike')->default('false');
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
        Schemma::dropIfExists('islike');
    }
}
