<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $body;
    public $mail_from;
    public $subject;
    public $email;
    public $path_files;
    public $dir;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $body, $email, $mail_from, $subject, $path_files, $dir)
    {
        $this->name = $name;
        $this->body = $body;
        $this->mail_from = $mail_from;
        $this->subject = $subject;
        $this->email = $email;
        $this->path_files = $path_files;
        $this->dir = $dir;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       $this->from($this->mail_from)
            ->view('admin.email.invitation')
            ->subject($this->subject)
            ->with(['name' => $this->name, 'body' => $this->body]);

            //Присоединение файлов к сообщению
            if($this->path_files && $this->dir) {
                $path_files_array = explode('|', $this->path_files);

                for ($i = 0; $i < count($path_files_array); $i++) {
                    $this->attach($this->dir . '/' . $path_files_array[$i]);
                }
            }

        return $this;
    }
}