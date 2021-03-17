<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessesLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('accesses_logs');

        Schema::create('access_logs', function (Blueprint $table) {
            $table->engine='MyISAM';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            // $table->uuid('id');
            $table->bigInteger('uid')->unsigned();
            $table->string('target_url');
            $table->string('http_type');
            $table->string('ua');
            $table->string('ip');
            $table->integer('created_at');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accesses_logs');
    }
}
