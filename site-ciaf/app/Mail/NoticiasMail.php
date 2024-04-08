<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Conteudo;

class NoticiasMail extends Mailable
{
    use Queueable, SerializesModels;
    public $noticia;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Conteudo $noticia)
    {
        $this->noticia = $noticia;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $noticia = $this->noticia;
        return $this->view('emails.noticia')->subject('Nova notícia no site do CIAF - '.$noticia->titulo);
    }
}
