<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('days', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('type_students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('idiomas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('class_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('course_states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('date_init')->nullable();
            $table->text('alumns')->nullable();
            $table->unsignedInteger('idioma_id');
            $table->unsignedInteger('teacher_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('coordinator_id');
            $table->unsignedInteger('type_student_id');
            $table->unsignedInteger('level_id');
            $table->unsignedInteger('coursestate_id')->default(1);
            $table->unsignedInteger('class_type_id');
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('material_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('coursestate_id')->references('id')->on('course_states')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('class_type_id')->references('id')->on('class_types')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            $table->foreign('idioma_id')->references('id')->on('idiomas')->onDelete('cascade');
            $table->foreign('type_student_id')->references('id')->on('type_students')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('coordinator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('course_days', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('day_id');
            $table->string('hour_start');
            $table->string('hour_end');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });

        Schema::create('course_user', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('course_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_days');
        Schema::dropIfExists('course_states');
        Schema::dropIfExists('course_user');
        Schema::dropIfExists('days');
        Schema::dropIfExists('type_students');
        Schema::dropIfExists('idiomas');
        Schema::dropIfExists('levels');
        Schema::dropIfExists('class_types');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('courses');
    }
}