<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('coordinator_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('coordinator_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('event_assistances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('assistances', function (Blueprint $table) {
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('event_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('event_assistances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clases');
        Schema::dropIfExists('event_assistances');
        Schema::dropIfExists('assistances');
    }
}