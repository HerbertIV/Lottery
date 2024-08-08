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
            $table->id();
            $table->unsignedInteger('lottery_session_id');
            $table->string('name', 255);
            $table->string('phone', 9);
            $table->boolean('can_draw')->default(true);
            $table->unsignedInteger('drawn_member_id')->nullable();
            $table->timestamps();

            $table->index('drawn_member_id', 'idx-members-drawn_member_id');
            $table->foreign('drawn_member_id', 'fk-members-drawn_member_id-members-id')->on('members')->references('id');
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
