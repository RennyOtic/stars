<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('rut')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('name_c');
            $table->string('email_c')->nullable()->unique();
            $table->string('phone_c')->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('nationalities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('how_finds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last_name');
            $table->date('birthday_date');
            $table->unsignedInteger('nationality_id');
            $table->unsignedInteger('company_id')->nullable();
            $table->string('how_find')->nullable();
            $table->string('occupation');
            $table->string('phone_movil');
            $table->string('phone_home');
            $table->string('num_id')->unique();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
        Schema::dropIfExists('nationalities');
        Schema::dropIfExists('how_finds');
        Schema::dropIfExists('users');
    }
}
