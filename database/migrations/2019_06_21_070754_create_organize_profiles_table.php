<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizeProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organize_profiles', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('display_name');
            $table->date('registration_date')->nullable()->default(null);
            $table->enum('group_size', ['none', '1 - 10', '11 - 50', '51 - 200', 'Over 200'])->default('none');
            $table->enum('salutation', ['none', 'mr', 'ms', 'mrs', 'miss', 'mdm', 'dr'])->default('none');
            $table->enum('gender', ['none', 'male', 'female'])->default('none');
            $table->enum('visibility', ['none', 'visible', 'hidden'])->default('none');

            $table->string('contact_person')->nullable();
            $table->string('public_email')->unique()->nullable();
            $table->string('phone_number')->nullable();

            $table->text('address')->nullable();

            $table->string('facebook')->nullable();
            $table->string('website')->nullable();

            $table->text('vision_mission')->nullable();
            $table->longText('our_programmes')->nullable();
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
        Schema::table('organize_profiles', function ($table) {
            $table->dropForeign('user_id');
        });
        Schema::dropIfExists('organize_profiles');
    }
}
