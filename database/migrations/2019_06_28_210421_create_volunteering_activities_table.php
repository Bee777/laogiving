<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteeringActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteering_activities', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->enum('volunteer_type', ['regular', 'ad-hoc'])->default('regular');
            $table->enum('frequency', ['', '1_DAY_PER_WEEK', '2_3_DAYS_PER_WEEK', 'FORTNIGHTLY', 'MONTHLY', 'QUARTERLY', 'FLEXIBLE', 'FULL_TIME'])->default('FLEXIBLE');
            $table->unsignedInteger('duration');
            $table->enum('weekday', ['yes', 'no'])->default('no');
            $table->enum('weekend', ['yes', 'no'])->default('no');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('deadline_sign_ups_date');

            $table->text('points_to_note')->nullable();
            $table->enum('volunteer_gender', ['yes', 'no'])->default('no');
            $table->enum('volunteer_contact_phone_number', ['yes', 'no'])->default('no');
            $table->string('other_response_required')->nullable();
            $table->enum('volunteer_signups_confirm', ['yes', 'no'])->default('no');

            //location
            $table->string('town');
            $table->string('block_street');
            $table->string('building_name')->nullable();
            $table->string('building_unit_number')->nullable();
            //contact detail
            $table->enum('contact_title', ['', 'mr', 'ms', 'mrs', 'miss', 'mdm', 'dr']);
            $table->string('contact_name');
            $table->string('contact_designation');
            $table->string('contact_phone_number');
            $table->string('contact_email');
            //status
            $table->enum('status', ['live', 'closed', 'cancelled', 'draft'])->default('live');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::table('volunteering_activities', function ($table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('volunteering_activities');
    }
}
