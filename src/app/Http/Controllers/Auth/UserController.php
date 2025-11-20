<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Models\PendingUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * ユーザー登録・更新・削除を扱うコントローラ.
 *
 * メール認証後の本登録処理やユーザー自身による情報更新、
 * アカウント削除などを提供する。
 */
class UserController extends Controller
{
    /**
     * メール認証済みの PendingUser 情報を元に本登録を行う
     *
     * @param StoreUserRequest $request
     *
     * @return JsonResponse
     *
     * @apiResponse 201 {"message": "アカウントを作成しました。"}
     * @apiResponse 400 {"error": "無効なトークンまたはメールアドレスです。"}
     * @apiResponse 500 {"error": "アカウントの作成に失敗しました。"}
     *
     * @phpstan-type StoreUserData array{
     *     name: string,
     *     email: string,
     *     password: string,
     *     token: string
     * }
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $pending_user = PendingUser::where('token', $request->token)
                ->where('email', $request->email)
                ->where('created_at', '>', now()->subMinutes(60))
                ->first();

            if (!$pending_user) {
                return response()->json(['error' => '無効なトークンまたはメールアドレスです。'], 400);
            }

            DB::transaction(function () use ($pending_user, $request): void {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $pending_user->email,
                    'password' => Hash::make($request->password),
                ]);

                $pending_user->delete();
                Auth::login($user);
            });

            return response()->json(['message' => 'アカウントを作成しました。'], 201);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'アカウントの作成に失敗しました。'], 500);
        }
    }

    /**
     * ユーザー情報（名前・メール）を更新する
     *
     * @param UpdateUserRequest $request
     *
     * @return JsonResponse
     *
     * @apiResponse 200 {"message": "ユーザー情報が更新されました。"}
     * @apiResponse 403 {"error": "外部ログインをしているユーザー情報は変更できません。"}
     * @apiResponse 500 {"error": "情報更新中にエラーが発生しました。"}
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        try {
            /** @var array{name:string, email:string} $data */
            $data = $request->validated();
            $user = $request->user();

            if (!$user instanceof User) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // LINEログインユーザーは更新不可
            if ($user->isLineUser()) {
                return response()->json(['error' => '外部ログインをしているユーザー情報は変更できません。'], 403);
            }

            $user->update($data);

            return response()->json(['message' => 'ユーザー情報が更新されました。'], 200);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => '情報更新中にエラーが発生しました。'], 500);
        }
    }

    /**
     * ユーザーアカウントを削除する
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @apiResponse 204 {"message":"アカウントを削除しました。"}
     * @apiResponse 403 {"error":"パスワードが正しくありません。"}
     * @apiResponse 500 {"error":"エラーが発生しました。"}
     *
     */
    public function destroy(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user instanceof User) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // LINEログインユーザーは password が null の可能性があるため
            if (!$user->isLineUser() &&
                    (!$user->password || !Hash::check($request->password, $user->password))) {

                return response()->json(['error' => 'パスワードが正しくありません。'], 403);
            }

            $user->delete();

            return response()->json(['message' => 'アカウントを削除しました.'], 204);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'エラーが発生しました。'], 500);
        }
    }
}
