<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteerProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteer_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('display_name');
            $table->string('public_email')->unique()->nullable();
            $table->date('date_of_birth')->nullable()->default(null);
            $table->enum('salutation', ['none', 'mr', 'ms', 'mrs', 'miss', 'mdm', 'dr'])->default('none');
            $table->enum('gender', ['none', 'male', 'female'])->default('none');
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->string('facebook')->nullable();
            $table->string('website')->nullable();
            $table->longText('about')->nullable();

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
        Schema::table('volunteer_profiles', function ($table) {
            $table->dropForeign('user_id');
        });
        Schema::dropIfExists('volunteer_profiles');
    }
}
