<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('assistance_id');
            $table->unsignedInteger('coordinator_id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('state')->nullable(); // 0) No Aprobado 1) Aprobado 
            $table->text('observation');
            $table->string('reschedule')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('assistance_id')->references('id')->on('assistances')->onDelete('cascade');
            $table->foreign('coordinator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
