<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this
            ->from('anhit146@gmail.com')
            ->view('mails.test');
    }
}
