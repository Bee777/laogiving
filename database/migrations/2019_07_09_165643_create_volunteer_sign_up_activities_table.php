<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteerSignUpActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteer_sign_up_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('leader', ['yes', 'no'])->default('no');
            $table->float('hour_per_volunteer')->default(0);
            $table->unsignedInteger('slot')->default(0);
            $table->unsignedBigInteger('volunteering_activity_position_id');
            $table->dateTime('sign_up_date');
            $table->dateTime('checkin_date')->nullable()->default(null);
            #optional
            $table->date('date_of_birth')->nullable()->default(null);
            $table->string('volunteer_contact_phone_number')->nullable();
            $table->text('other_response_required')->nullable();
            //status
            $table->enum('status', ['confirm', 'rejected', 'pending', 'checkin'])->default('pending');
            $table->unsignedBigInteger('volunteering_activity_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('volunteering_activity_id')
                ->references('id')->on('volunteering_activities')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::table('volunteer_sign_up_activities', function ($table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['volunteering_activity_id']);
        });
        Schema::dropIfExists('volunteer_sign_up_activities');
    }
}
