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
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name')->commet('nome utente');
                $table->string('type')->comment('tipo utente: admin|webmaster');
                $table->string('email')->unique()->comment('email di accesso');
                $table->timestamp('email_verified_at')->nullable()->comment('data/ora verifica email');
                $table->string('password')->comment('password di accesso');
                $table->rememberToken()->comment('remember token');
                $table->timestamps();
                $table->softDeletes();
            });
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
