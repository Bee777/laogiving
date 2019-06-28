<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteeringActivityPositionSuitablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteering_activity_position_suitables', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('volunteering_activity_position_id');
            $table->foreign('volunteering_activity_position_id', 'suitable_volun_acti_position_id_foreign')
                ->references('id')->on('volunteering_activity_positions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('suitable_id');
            $table->foreign('suitable_id')
                ->references('id')->on('suitables')
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
        Schema::table('volunteering_activity_position_suitables', function ($table) {
            $table->dropForeign(['suitable_id']);
        });
        Schema::dropIfExists('volunteering_activity_position_suitables');
    }
}
