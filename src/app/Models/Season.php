<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'start_date',
        'end_date',
        'competition_id',
    ];

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function standings()
    {
        return $this->hasMany(Standing::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
