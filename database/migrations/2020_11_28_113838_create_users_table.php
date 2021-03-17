<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->tinyInteger('gender')->unsigned()->default(0);
            $table->string('email')->nullable();
            $table->tinyInteger('email_state')->nullable()->unsigned();
            $table->string('phone')->nullable();
            $table->string('mc_id')->nullable();
            $table->string('qq')->nullable();
            $table->integer('birthday')->nullable();
            $table->string('signature')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('deleted_at')->nullable();
            $table->char('last_ip', 32)->nullable();
            $table->bigInteger('last_time')->default(0);
            $table->tinyInteger('mc_id_bool')->nullable()->unsigned();
            $table->string('name')->nullable();
            $table->string('token')->nullable();
            $table->string('login_token')->nullable();
            $table->string('qq_id')->nullable();
            $table->string('nickname')->nullable();
            $table->tinyInteger('is_admin')->unsigned()->default(0);
            $table->string('avatar_url')->default('http://localhost/avatar/default');
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
