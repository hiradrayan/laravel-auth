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
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('province_id')->nullable()->before('updated_at')->constrained('province_cities');
                $table->foreignId('city_id')->nullable()->after('province_id')->constrained('province_cities');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('city_id');
            $table->dropConstrainedForeignId('province_id');
        });
    }
};
