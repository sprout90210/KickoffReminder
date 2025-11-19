<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;

class Competition extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'current_season_id',
        'name',
        'code',
        'competition_type',
        'embleme',
    ];

    /**
     * @return HasMany<\App\Models\Season>
     */
    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }

    /**
     * @return HasMany<\App\Models\Standing>
     */
    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class);
    }

    /**
     * @return HasMany<\App\Models\Game>
     */
    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }
}
