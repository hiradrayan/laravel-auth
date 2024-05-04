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
            Schema::create('province_cities', function (Blueprint $table) {
                $table->id();
                $table->foreignId('parent_id')->nullable()->constrained('province_cities');
                $table->string('title');
                $table->integer('sort');
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
