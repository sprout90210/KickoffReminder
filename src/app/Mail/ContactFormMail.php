<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $formData;

    protected $name;

    protected $fromEmail;

    protected $toEmail;

    public function __construct($formData)
    {
        $this->formData = $formData;
        $this->name = config('mail.from.name');
        $this->fromEmail = config('mail.from.address');
        $this->toEmail = config('mail.to.developer_address');
    }

    public function build()
    {
        return $this->to($this->toEmail)
            ->from($this->fromEmail, $this->name)
            ->subject('お問い合わせがありました')
            ->view('emails.contact')
            ->with(['formData' => $this->formData]);
    }
}
