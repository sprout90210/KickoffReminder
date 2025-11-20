<?php 
namespace App\Services;

use App\Exceptions\{AlreadyFavoritedException, FavoriteLimitException, FavoriteNotFoundException};
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Collection;

class FavoriteService
{
    /**
     * 指定ユーザーのお気に入り一覧を取得する
     *
     * @param int $user_id ユーザーID
     * @return Collection<int, Favorite> お気に入り一覧（team リレーション付き）
     */
    public function getFavorites(int $user_id): Collection
    {
        return Favorite::with('team')
            ->where('user_id', $user_id)
            ->get();
    }

    /**
     * お気に入りを追加する
     *
     * @param int $user_id ユーザーID
     * @param int $team_id チームID
     * @throws AlreadyFavoritedException
     * @throws FavoriteLimitException
     */
    public function addFavorite(int $user_id, int $team_id): void
    {
        if ($this->isAlreadyFavorited($user_id, $team_id)) {
            throw new AlreadyFavoritedException();
        }

        if ($this->isFavoritesLimitReached($user_id)) {
            throw new FavoriteLimitException();
        }

        Favorite::create([
            'user_id' => $user_id,
            'team_id' => $team_id,
        ]);
    }

    /**
     * お気に入りを解除する
     *
     * @param int $user_id ユーザーID
     * @param int $team_id チームID
     * @throws FavoriteNotFoundException
     */
    public function removeFavorite(int $user_id, int $team_id): void
    {
        $deleted = Favorite::where('user_id', $user_id)
            ->where('team_id', $team_id)
            ->delete();

        if ($deleted === 0) {
            throw new FavoriteNotFoundException();
        }
    }

    /**
     * すでにお気に入り登録されているか判定する
     *
     * @param int $user_id ユーザーID
     * @param int $team_id チームID
     * @return bool 登録済みなら true
     */
    private function isAlreadyFavorited(int $user_id, int $team_id): bool
    {
        return Favorite::where('user_id', $user_id)
                ->where('team_id', $team_id)
                ->exists();
    }

    /**
     * お気に入り登録数が上限に達しているかを判定する
     *
     * @param int $user_id ユーザーID
     * @return bool 上限（10件）に達していたら true
     */
    private function isFavoritesLimitReached(int $user_id): bool
    {
        return Favorite::where('user_id', $user_id)->count() >= 10;
    }
}
