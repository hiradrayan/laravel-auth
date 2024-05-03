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
            if (config('authentication.database.required.national_id'))
            {
                $table->string('national_id', 10)->unique()->after('id');
            } else {
                $table->string('national_id', 10)->unique()->after('id')->nullable();
            }
            $table->string('mobile',11)->unique()->after('national_id');

            if (config('authentication.database.required.email'))
            {
                $table->string('email')->unique()->after('mobile');
            } else {
                $table->string('email')->unique()->after('mobile')->nullable();
            }

            $table->string('address')->nullable()->after('mobile');
            $table->string('gender',1)->nullable()->after('mobile');
            $table->string('last_name')->nullable()->after('mobile');
            $table->string('first_name')->nullable()->after('mobile');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
