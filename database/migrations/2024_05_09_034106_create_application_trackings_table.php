<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_trackings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->bigInteger('ApplicationID')->unsigned();
            $table->integer('ApproverID')->unsigned();
            $table->string('fileUpload')->nullable();
            $table->string('remark');
            $table->string('status');
            $table->foreign('ApplicationID')->references('id')->on('applications')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('ApproverID')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('application_trackings');
    }
}
