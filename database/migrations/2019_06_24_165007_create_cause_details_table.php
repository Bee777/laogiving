<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCauseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cause_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['user', 'activity'])->default('user');
            $table->unsignedBigInteger('related_id');
            $table->unsignedBigInteger('cause_id');
            $table->foreign('cause_id')
                ->references('id')->on('causes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::table('cause_details', function ($table) {
            $table->dropForeign('cause_id');
        });
        Schema::dropIfExists('cause_details');
    }
}
