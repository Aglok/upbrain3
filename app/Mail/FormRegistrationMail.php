<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('email@upbrain.ru')
            ->view('admin.email.form_registration')
            ->subject('Курсы подготовки Upbrain')
            ->with(['email' => $this->email]);
    }
}