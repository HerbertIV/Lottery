<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'name',
        'phone',
    ];

    protected $with = [
        'lotterySession'
    ];

    public function lotterySessionTurnsMember(): HasMany
    {
        return $this->hasMany(LotterySessionTurnMember::class, 'member_uuid', 'uuid');
    }

    public function lotterySession(): HasOne
    {
        return $this->hasOne(LotterySession::class, 'id', 'lottery_session_id');
    }


    public function canDraw(?LotterySessionTurn $activeLotterySessionTurn = null): bool
    {
        if (isset($this->can_draw)) {

            return $this->can_draw;
        }
        $activeLotterySessionTurn = $activeLotterySessionTurn ?:
            $this->lotterySession->activeLotterySessionTurns->first();

        return $activeLotterySessionTurn && $this
                ->query()
                ->joinRelationship('lotterySessionTurnsMember')
                ->where('members.uuid', '=', $this->getKey())
                ->where('lottery_session_turn_id', '=', $activeLotterySessionTurn->getKey())->count() === 0;
    }
}
