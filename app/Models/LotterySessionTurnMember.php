<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LotterySessionTurnMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'lottery_session_turn_id',
        'member_uuid',
        'drawn_member_uuid'
    ];

    protected $casts = [
        'lottery_session_turn_id' => 'int',
        'member_uuid' => 'string'
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_uuid', 'uuid');
    }

    public function drawnMember(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'drawn_member_uuid', 'uuid');
    }

    public function lotterySessionTurn(): BelongsTo
    {
        return $this->belongsTo(LotterySessionTurn::class, 'lottery_session_turn_id', 'id');
    }
}
