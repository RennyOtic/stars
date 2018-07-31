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
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('type_students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('idiomas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('class_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('slug', 100)->unique();
            $table->string('code', 25)->unique();
            $table->string('hour_start', 10);
            $table->string('hour_end', 10);
            $table->unsignedInteger('idioma_id');
            $table->unsignedInteger('teacher_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('max_students');
            $table->unsignedInteger('max_class');
            $table->unsignedInteger('type_student_id');
            $table->unsignedInteger('level_id');
            $table->unsignedInteger('class_type_id');
            $table->date('date_start_at');
            $table->date('date_inscription_start_at');
            $table->date('date_inscription_end_at');
            $table->date('date_end_at');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('class_type_id')->references('id')->on('class_types')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            $table->foreign('idioma_id')->references('id')->on('idiomas')->onDelete('cascade');
            $table->foreign('type_student_id')->references('id')->on('type_students')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('course_day', function (Blueprint $table) {
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('day_id');

            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });

        Schema::create('course_material', function (Blueprint $table) {
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('material_id');

            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
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
        Schema::dropIfExists('days_weeks');
        Schema::dropIfExists('type_students');
        Schema::dropIfExists('idiomas');
        Schema::dropIfExists('levels');
        Schema::dropIfExists('class_types');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('course_material');
        Schema::dropIfExists('course_day');
        Schema::dropIfExists('course_user');
    }
}
