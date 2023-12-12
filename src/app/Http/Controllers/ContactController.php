<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function send(ContactFormRequest $request)
    {
        try{
            $formData = $request->all();
            Mail::send(new ContactFormMail($formData));

            return response()->json(['message' => 'メール送信に成功しました。'], 200);
        } catch (\Exception $e) {
            Log::error("Mail sending failed: " . $e->getMessage());
            return response()->json(['error' => 'メール送信に失敗しました。'], 500);
        }
    }
}
