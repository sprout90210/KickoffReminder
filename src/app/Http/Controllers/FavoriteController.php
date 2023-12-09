<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Symfony\Component\HttpFoundation\Response;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $favoriteTeams = Favorite::where('user_id', $user_id)
            ->with('team')
            ->get();
            
        if($favoriteTeams->isEmpty()){
            return response()->json(['error' => 'お気に入りが見つかりません。'], 404);
        }
        return response()->json($favoriteTeams, 200);

    }


    public function store(Request $request)
    {
        $user_id = $request->user()->id;
        $team_id = $request->input('team_id');

        if ($this->isAlreadyFavorited($user_id, $team_id)) {
            return response()->json(['error' => 'お気に入り登録済みです。'], 409);
        }

        if ($this->isFavoritesLimitReached($user_id)) {
            return response()->json(['error' => 'お気に入りの登録上限に達しました。'], 422);
        }

        $favorite = Favorite::create([
            'user_id' => $user_id,
            'team_id' => $team_id,
        ]);

        return response()->json(['message' => 'お気に入り登録しました。'], 200);
    }


    public function destroy($team_id, Request $request)
    {
        $user_id = $request->user()->id;
        $deleted = Favorite::where('user_id', $user_id)->where('team_id', $team_id)->delete();

        if ($deleted > 0) {
            return response()->json(['message' => 'お気に入り解除しました。'], 200);
        }
        return response()->json(['error' => 'お気に入りが見つかりません。'], 404);
    }


    protected function isAlreadyFavorited($userId, $teamId)
    {
        return Favorite::where('user_id', $userId)->where('team_id', $teamId)->exists();
    }

    protected function isFavoritesLimitReached($userId)
    {
        return Favorite::where('user_id', $userId)->count() >= 10;
    }
}
