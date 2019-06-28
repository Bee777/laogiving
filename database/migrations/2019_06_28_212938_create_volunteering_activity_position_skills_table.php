<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteeringActivityPositionSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteering_activity_position_skills', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('volunteering_activity_position_id');
            $table->foreign('volunteering_activity_position_id', 'skill_volun_acti_position_id_foreign')
                ->references('id')->on('volunteering_activity_positions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('skill_id');
            $table->foreign('skill_id')
                ->references('id')->on('skills')
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
        Schema::table('volunteering_activity_position_skills', function (Blueprint $table) {
            $table->dropForeign(['skill_id']);
        });
        Schema::dropIfExists('volunteering_activity_position_skills');
    }
}
