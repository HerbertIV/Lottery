<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LotterySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_name',
        'status'
    ];



    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function lotterySessionTurns(): HasMany
    {
        return $this->hasMany(LotterySessionTurn::class);
    }

    public function activeLotterySessionTurns(): HasMany
    {
        $now = now();

        return $this->lotterySessionTurns()
            ->where('date_from', '<=', $now->format('Y-m-d'))
            ->where('date_to', '>=', $now->format('Y-m-d'));
    }

}
