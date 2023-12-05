<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactFormRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function send(ContactFormRequest $request)
    {
        try{
            $formData = $request->all();
            Mail::to('kickoffreminder@gmail.com')->send(new ContactFormMail($formData));

            return response()->json(['message' => 'メール送信に成功しました。'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'メール送信に失敗しました。'], 500);
        }
    }
}
