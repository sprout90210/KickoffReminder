<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function getFavoriteTeamIds(User $user): array
    {
        return $user->favorites()->pluck('team_id')->toArray();
    }
}
