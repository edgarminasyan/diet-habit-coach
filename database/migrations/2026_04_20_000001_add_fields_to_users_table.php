<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('timezone')->default('UTC')->after('email');
            $table->integer('daily_calorie_goal')->nullable()->after('timezone');
            $table->integer('daily_protein_goal')->nullable()->after('daily_calorie_goal');
            $table->integer('daily_carbs_goal')->nullable()->after('daily_protein_goal');
            $table->integer('daily_fat_goal')->nullable()->after('daily_carbs_goal');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['timezone','daily_calorie_goal','daily_protein_goal','daily_carbs_goal','daily_fat_goal']);
        });
    }
};
