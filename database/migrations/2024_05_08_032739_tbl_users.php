<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('deptID')->unsigned();
            $table->bigInteger('roleID')->unsigned();
            $table->bigInteger('centreID')->unsigned();
            $table->tinyInteger('Status')->default('1');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('users', function($table) {
            $table->engine = 'InnoDB';
            $table->foreign('deptID')->references('id')->on('tbldepartment')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('roleID')->references('id')->on('tblrole')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('centreID')->references('id')->on('tblcentre')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
