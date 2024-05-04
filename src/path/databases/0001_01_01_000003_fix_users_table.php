<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'national_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropUnique('users_national_id_unique');
                    $table->dropColumn('national_id');
                });
            }
            if (Schema::hasColumn('users', 'name')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('name');
                });
            }
            if (Schema::hasColumn('users', 'email')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropUnique('users_email_unique');
                    $table->dropColumn('email');
                });
            }
            if (config('authentication.authentication') == 'national_id')
            {
                $table->string('national_id', 10)->unique()->after('id');
                $table->string('mobile',11)->after('national_id');
                $table->timestamp('mobile_verified_at')->nullable()->after('mobile');
            }
            
            foreach (Arr::except(config('authentication.database.registerFields'), ['national_id', 'password', 'password_confirmation', 'mobile', 'province_and_city']) as $key => $value)
            {
                $table->string($key)->nullable(!$value)->after('mobile');
            }


        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
