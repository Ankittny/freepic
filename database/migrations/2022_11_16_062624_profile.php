<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Profile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('profile',function(Blueprint $table){
        $table->bigIncrements('id');
        $table->string('userid')->nullable();
        $table->longText('cnctFrnd')->nullable();
        $table->string('desc')->nullable();
        $table->string('dob')->nullable();
        $table->longText('drinking')->nullable();
        $table->longText('education')->nullable();
        $table->string('email')->nullable();
        $table->string('findPartner')->nullable();
        $table->string('mobileNum')->nullable();
        $table->string('whatsappNum')->nullable();
        $table->string('gender')->nullable();
        $table->string('height')->nullable();
        $table->string('location')->nullable();
        $table->longText('maritalStatus')->nullable();
        $table->longText('smoking')->nullable();
        $table->string('spendTime')->nullable();
        $table->string('username')->nullable();
        $table->string('weight')->nullable();
        $table->string('isLock')->default('false');
        $table->string('isFriend')->default('false');
        $table->string('isBlock')->default('false');
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
        Schema::dropIfExists('timestamps');
    }
}
