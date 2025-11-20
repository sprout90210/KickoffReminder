<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactFormMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * お問い合わせフォームの送信を扱うコントローラ.
 *
 * バリデーション済みのフォームデータをメールとして送信し、
 * 成功/失敗に応じて JSON レスポンスを返す。
 */
class ContactController extends Controller
{
    /**
     * お問い合わせメールを送信する
     *
     * @param ContactFormRequest $request
     *     バリデーション済みのリクエスト
     *
     * @return JsonResponse
     *
     * @apiResponse 200 {"message":"お問合せを送信しました。"}
     * @apiResponse 500 {"error":"お問合せ送信に失敗しました。"}
     */
    public function send(ContactFormRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            Mail::send(new ContactFormMail($formData));

            return response()->json(['message' => 'お問合せを送信しました。'], 200);

        } catch (\Exception $e) {
            Log::error('Mail sending failed: ' . $e->getMessage());
            return response()->json(['error' => 'お問合せ送信に失敗しました。'], 500);
        }
    }
}
