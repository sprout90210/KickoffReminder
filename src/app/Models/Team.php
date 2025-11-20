<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'short_name',
        'crest',
        'venue',
        'website_url',
        'twitter_url',
        'youtube_url',
        'insatgram_url',
    ];

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
    public function homeGames(): HasMany
    {
        return $this->hasMany(Game::class, 'home_team_id');
    }

    /**
     * @return HasMany<\App\Models\Game>
     */
    public function awayGames(): HasMany
    {
        return $this->hasMany(Game::class, 'away_team_id');
    }

    /**
     * @return HasMany<\App\Models\Favorite>
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
