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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('nip', 18)->unique();
            $table->string('username', 18)->unique();
            $table->string('password');
            $table->string('kdunit', 20);
            $table->string('eselon', 2);
            $table->string('kdlevel', 2);
            $table->enum('api', ['y','n']);
            $table->enum('aktif', ['y','n']);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
