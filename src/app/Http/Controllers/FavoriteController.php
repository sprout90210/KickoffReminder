<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavoriteRequest;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $favorites = Favorite::where('user_id', $user_id)
            ->with('team')
            ->get();

        return response()->json($favorites, 200);
    }

    public function store(StoreFavoriteRequest $request)
    {
        $user_id = $request->user()->id;
        $team_id = $request->team_id;

        if ($this->isAlreadyFavorited($user_id, $team_id)) {
            return response()->json(['message' => 'すでにお気に入り登録済みです。'], 409);
        }

        if ($this->isFavoritesLimitReached($user_id)) {
            return response()->json(['message' => 'お気に入り登録数の上限に達しました。'], 422);
        }

        Favorite::create([
            'user_id' => $user_id,
            'team_id' => $team_id,
        ]);

        return response()->json(['message' => 'お気に入り登録しました。'], 201);
    }

    public function destroy($team_id, Request $request)
    {
        $user_id = $request->user()->id;
        $deleted = Favorite::where('user_id', $user_id)->where('team_id', $team_id)->delete();

        if ($deleted > 0) {
            return response()->json(['message' => 'お気に入りを解除しました。'], 204);
        }

        return response()->json(['message' => 'お気に入り削除に失敗しました。'], 404);
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
