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
        'phone'
    ];

    public function lotterySession(): BelongsTo
    {
        return $this->belongsTo(LotterySession::class);
    }

    public function scopeWasDrawn(Builder $query): void
    {
        $query->whereWasDrawn(true);
    }

    public function scopeHasDrawn(Builder $query): void
    {
        $query->whereHasDrawn(true);
    }
}
