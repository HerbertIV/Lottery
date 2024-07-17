<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LotterySession extends Model
{
    use HasFactory;

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function membersWasDrawn(): HasMany
    {
        return $this->members()->wasDrawn();
    }

    public function membersHasDrawn(): HasMany
    {
        return $this->members()->hasDrawn();
    }
}
