<?php

namespace App\Models;

use BaoPham\DynamoDb\H;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LotterySessionTurn extends Model
{
    use HasFactory;

    protected $fillable = [
        'lottery_session_id',
        'date_from',
        'date_to',
    ];

    protected $casts = [
        'date_from' => 'datetime',
        'date_to' => 'datetime',
    ];

    public function lotterySession(): BelongsTo
    {
        return $this->belongsTo(LotterySession::class);
    }

    public function lotterySessionTurnMembers(): HasMany
    {
        return $this->hasMany(
            LotterySessionTurnMember::class,
            'lottery_session_turn_id',
            'id'
        );
    }

    public function scopeActiveSession()
    {
        $now = now();

        return $this
            ->where('date_from', '<=', $now->format('Y-m-d'))
            ->where('date_to', '>=', $now->format('Y-m-d'));
    }
}
