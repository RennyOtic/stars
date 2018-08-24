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
            $table->string('name', 50);
            $table->string('rut', 20)->unique();
            $table->string('email', 50)->unique();
            $table->string('phone', 50)->unique();
            $table->string('name_c', 50);
            $table->string('email_c', 80)->nullable()->unique();
            $table->string('phone_c', 50)->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('nationalities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('how_finds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 35);
            $table->string('last_name', 35);
            $table->date('birthday_date');
            $table->unsignedInteger('nationality_id');
            $table->unsignedInteger('company_id')->nullable();
            $table->string('how_find', 50)->nullable();
            $table->string('occupation', 30);
            $table->string('phone_movil', 20);
            $table->string('phone_home', 20);
            $table->string('num_id', 20)->unique();
            $table->string('email', 50)->unique();
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
