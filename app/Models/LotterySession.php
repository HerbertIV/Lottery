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

    public function membersCanDraw(): HasMany
    {
        return $this->members()->canDraw();
    }

    public function membersCanNotDraw(): HasMany
    {
        return $this->members()->canNotDraw();
    }

    public function membersNotDrawn(): HasMany
    {
        return $this->members()->notDrawn();
    }

    public function membersDrawn(): HasMany
    {
        return $this->members()->drawn();
    }

}
