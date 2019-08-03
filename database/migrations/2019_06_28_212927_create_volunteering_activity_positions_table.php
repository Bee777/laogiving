<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteeringActivityPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteering_activity_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedInteger('vacancies');
            $table->unsignedInteger('minimum_age')->nullable();
            $table->text('key_responsibilities_impact');

            $table->unsignedBigInteger('volunteering_activity_id');
            $table->foreign('volunteering_activity_id')
                ->references('id')->on('volunteering_activities')
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
        Schema::table('volunteering_activity_positions', function ($table) {
            $table->dropForeign(['volunteering_activity_id']);
        });
        Schema::dropIfExists('volunteering_activity_positions');
    }
}
