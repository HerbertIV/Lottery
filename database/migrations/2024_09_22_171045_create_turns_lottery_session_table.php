<?php

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
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign('fk-members-drawn_member_uuid-members-uuid');
            $table->dropIndex('idx-members-drawn_member_uuid');
        });
        Schema::dropColumns('members', [
            'drawn_member_uuid',
            'can_draw',
            'drawn'
        ]);
        Schema::create('lottery_session_turns', static function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lottery_session_id')->unsigned();
            $table->timestamp('date_from');
            $table->timestamp('date_to');
            $table->timestamps();

            $table->index('lottery_session_id');
            $table->foreign('lottery_session_id')->references('id')->on('lottery_sessions')->onDelete('cascade');
        });
        Schema::create('lottery_session_turn_members', static function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lottery_session_turn_id')->unsigned();
            $table->uuid('member_uuid');
            $table->uuid('drawn_member_uuid');
            $table->timestamps();

            $table->unique(['lottery_session_turn_id', 'member_uuid', 'drawn_member_uuid']);
            $table->index('lottery_session_turn_id');
            $table->index('member_uuid');
            $table->index('drawn_member_uuid');
            $table->foreign('lottery_session_turn_id')->references('id')->on('lottery_session_turns')->onDelete('cascade');
            $table->foreign('member_uuid')->references('uuid')->on('members')->onDelete('cascade');
            $table->foreign('drawn_member_uuid')->references('uuid')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lottery_session_turn_members');
        Schema::dropIfExists('lottery_session_turns');
        Schema::table('members', static function (Blueprint $table) {
            $table->unsignedBigInteger('lottery_session_id');
            $table->unsignedBigInteger('drawn_member_uuid');
            $table->unsignedBigInteger('can_draw');
            $table->unsignedBigInteger('drawn');

            $table->index('drawn_member_uuid', 'idx-members-drawn_member_uuid');
            $table->foreign('drawn_member_uuid', 'fk-members-drawn_member_uuid-members-uuid')
                ->on('members')
                ->references('uuid')
                ->cascadeOnDelete();
        });
    }
};
