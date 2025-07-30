<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecategorizarReporte extends Mailable
{
   use Queueable, SerializesModels;

    public $info;

    /**
     * Create a new message instance.
     */
    public function __construct($datos)
    {
        $this->info = $datos;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tienes un nuevo reporte para gestionar',
        );
    }

    public function build()
    {
        return $this->view('mail.recategorizar_reportes');
    }
}
