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
        $registerFields = config('authentication.database.registerFields');
        if (is_array($registerFields) && array_key_exists('province_and_city', $registerFields)) {
            Schema::create('provinces', function (Blueprint $table) {
                $table->id();
                $table->string('name' , 90);
                $table->boolean('status')->default(0);
                $table->timestamps();
            });

            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->foreignId('province_id')->constrained('provinces')->onDelete('cascade')->onUpdate('cascade');
                $table->string('name' , 90);
                $table->boolean('status')->default(0);
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('province_cities');
    }
};
