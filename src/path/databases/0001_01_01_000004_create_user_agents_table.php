<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('hash')->unique();
            $table->boolean('is_active')->default(false);
            $table->string('agent')->nullable();
            $table->dateTime('login_at')->nullable();
            $table->string('login_ip',15)->nullable();
            $table->dateTime('logout_at')->nullable();
            $table->string('logout_ip',15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_agents');
    }
};
