<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(ContactFormRequest $request)
    {
        try {
            $formData = $request->all();
            Mail::send(new ContactFormMail($formData));

            return response()->json(['message' => 'お問合せを送信しました。'], 200);

        } catch (\Exception $e) {
            Log::error('Mail sending failed: '.$e->getMessage());

            return response()->json(['message' => 'お問合せ送信に失敗しました。'], 500);
        }
    }
}
