<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CoursesMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $type;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $type, $subject)
    {
        $this->email = $email;
        $this->type = $type;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('email@upbrain.ru')
            ->view('admin.email.courses')
            ->subject('Курсы подготовки Upbrain')
            ->with(['email' => $this->email, 'type' => $this->type, 'subject' => $this->subject]);
    }
}