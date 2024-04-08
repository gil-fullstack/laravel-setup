<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Download;

class DownloadMail extends Mailable
{
    use Queueable, SerializesModels;
    public $download;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Download $download)
    {
        $this->download = $download;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.download')->subject('Bem-vindo! CIAF – Soluções em Software');
    }
}
