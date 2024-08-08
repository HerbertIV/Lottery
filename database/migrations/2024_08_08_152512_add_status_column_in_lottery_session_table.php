<?php

use App\Enums\LotterySessionStatuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lottery_sessions', function (Blueprint $table) {
            $table->enum('status', LotterySessionStatuses::values())->default(LotterySessionStatuses::UN_ACTIVE);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lottery_sessions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
