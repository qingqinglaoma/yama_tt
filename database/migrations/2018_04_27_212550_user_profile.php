<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	Schema::create('profiles', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->string('address',50);
	    $table->string('city',20);
	    $table->string('state',20);
	    $table->string('about',255);
            $table->string('picture');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
	Schema::dropIfExists('profiles');
    }
}
