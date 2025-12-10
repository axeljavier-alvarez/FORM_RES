<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevaSolicitudAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $solicitud;

    public function __construct($solicitud)
    {
        $this->solicitud = $solicitud;
    }

    public function build()
    {
        return $this->subject("Nueva solicitud registrada: 
        {$this->solicitud->no_solicitud}")
        ->view('emails.nueva-solicitud-admin');
    }

    
}
