<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_flows', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('deptID')->unsigned();
            $table->foreign('deptID')->references('id')->on('departments')->onUpdate('cascade')->onDelete('restrict');
            $table->bigInteger('roleID')->unsigned();
            $table->foreign('roleID')->references('id')->on('roles')->onUpdate('cascade')->onDelete('restrict');
            $table->bigInteger('centreID')->unsigned();
            $table->foreign('centreID')->references('id')->on('centres')->onUpdate('cascade')->onDelete('restrict');
            $table->bigInteger('Approver')->unsigned();
            $table->foreign('Approver')->references('id')->on('roles')->onUpdate('cascade')->onDelete('restrict');
            $table->bigInteger('range')->unsigned();
            $table->foreign('range')->references('id')->on('price_ranges')->onUpdate('cascade')->onDelete('restrict');
            $table->bigInteger('sequence');
            $table->bigInteger('Status');
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
        Schema::dropIfExists('approval_flows');
    }
}
