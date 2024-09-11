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
        Schema::create('members', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->unsignedBigInteger('lottery_session_id');
            $table->string('name', 255);
            $table->string('phone', 9);
            $table->boolean('can_draw')->default(true);
            $table->uuid('drawn_member_uuid')->nullable();
            $table->timestamps();

            $table->index('drawn_member_uuid', 'idx-members-drawn_member_uuid');
            $table->foreign('drawn_member_uuid', 'fk-members-drawn_member_uuid-members-uuid')
                ->on('members')
                ->references('uuid')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
