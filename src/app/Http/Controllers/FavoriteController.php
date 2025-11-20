<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavoriteRequest;
use App\Services\FavoriteService;
use App\Exceptions\{AlreadyFavoritedException, FavoriteLimitException, FavoriteNotFoundException};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * ユーザーのお気に入りチームを管理するコントローラ.
 *
 * 一覧取得・登録・解除の API を提供する。
 */
class FavoriteController extends Controller
{
    /**
     * @var FavoriteService
     */
    private FavoriteService $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    /**
     * お気に入り一覧を返す（認証必須）
     *
     * @return JsonResponse
     *
     * @apiResponse 200 list<Favorite>
     * @apiResponse 401 {"message":"Unauthorized"}
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json(
            $this->favoriteService->getFavorites($user->id),
            200
        );
    }

    /**
     * お気に入りを登録する
     *
     * @param StoreFavoriteRequest $request
     * @return JsonResponse
     *
     * @apiResponse 201 {"message":"お気に入り登録しました。"}
     * @apiResponse 409 {"error":"すでにお気に入り登録済みです。"}
     * @apiResponse 422 {"error":"お気に入り登録数の上限に達しました。"}
     */
    public function store(StoreFavoriteRequest $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $userId = $user->id;
        $teamId = $request->teamId;

        try {
            $this->favoriteService->addFavorite($userId, $teamId);
            return response()->json(['message' => 'お気に入り登録しました。'], 201);

        } catch (AlreadyFavoritedException $e) {
            return response()->json(['error' => $e->getMessage()], 409);

        } catch (FavoriteLimitException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * 指定されたチームIDのお気に入りを解除する
     *
     * @param int $teamId
     * @param Request $request
     * @return JsonResponse
     *
     * @apiResponse 200 {"message":"お気に入りを解除しました。"}
     * @apiResponse 404 {"error":"お気に入り解除に失敗しました。"}
     */
    public function destroy(int $teamId, Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $userId = $user->id;
        try {
            $this->favoriteService->removeFavorite($userId, $teamId);
            return response()->json(['message' => 'お気に入りを解除しました。'], 200);

        } catch (FavoriteNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
