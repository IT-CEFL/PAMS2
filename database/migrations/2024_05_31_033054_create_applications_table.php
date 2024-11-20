<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer('UserID')->unsigned();
            $table->string('applicationNumber');
            $table->string('file');
            $table->bigInteger('TypeID')->unsigned();
            $table->bigInteger('CurrencyID')->unsigned();
            $table->decimal('expectedAmount',8,2);
            $table->decimal('disbursedAmount',8,2);
            $table->string('remark');
            $table->string('status')->nullable();
            $table->bigInteger('previousApp')->unsigned();
            $table->bigInteger('nextApp')->unsigned();
            $table->foreign('previousApp')->references('id')->on('roles')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('nextApp')->references('id')->on('roles')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('UserID')->references('id')->on('user')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('TypeID')->references('id')->on('types')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('CurrencyID')->references('id')->on('currencies')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('applications');
    }
}
