<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var array<string, mixed> */
    protected array $formData;

    /** @var string */
    protected string $name;

    /** @var string */
    protected string $fromEmail;

    /** @var string */
    protected string $toEmail;

    /**
     * @param array<string, mixed> $formData
     */
    public function __construct(array $formData)
    {
        $this->formData = $formData;
        $this->name = config('mail.from.name');
        $this->fromEmail = config('mail.from.address');
        $this->toEmail = config('mail.to.developer_address');
    }

    public function build(): self
    {
        return $this->to($this->toEmail)
            ->from($this->fromEmail, $this->name)
            ->subject('お問い合わせがありました')
            ->view('emails.contact')
            ->with(['formData' => $this->formData]);
    }
}
