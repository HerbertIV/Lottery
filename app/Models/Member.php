<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'drawn_member_id',
        'can_draw',
        'drawn',
    ];

    public function lotterySession(): BelongsTo
    {
        return $this->belongsTo(LotterySession::class);
    }


    public function memberDrawn(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'drawn_member_id');
    }

    public function scopeCanDraw(Builder $query): void
    {
        $query->whereCanDraw(true);
    }

    public function scopeCanNotDraw(Builder $query): void
    {
        $query->whereCanDraw(false);
    }

    public function scopeNotDrawn(Builder $query): void
    {
        $query->whereDrawn(false);
    }

    public function scopeDrawn(Builder $query): void
    {
        $query->whereDrawn(true);
    }

}
