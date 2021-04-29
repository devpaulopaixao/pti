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
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('cpf')->unique()->nullable();
            $table->string('rg')->nullable();
            $table->string('genre')->nullable();
            $table->string('phone')->nullable();
            $table->string('cell')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('district')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('pagarme_id')->nullable();
            $table->string('password');
            //COLUMN TO JWT VALIDATION
            $table->string('api_token', 80)->unique()->nullable()->default(null);

            $table->rememberToken();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE users ADD avatar_blob MEDIUMBLOB");
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
