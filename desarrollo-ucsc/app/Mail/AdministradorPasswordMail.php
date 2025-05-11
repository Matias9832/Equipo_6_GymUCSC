<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdministradorPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre_admin;
    public $password;

    /**
     * Create a new message instance.
     *
     * @param string $nombre_admin
     * @param string $password
     */
    public function __construct($nombre_admin, $password)
    {
        $this->nombre_admin = $nombre_admin;
        $this->password = $password;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Credenciales de Administrador',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.administrador_password',
            with: [
                'nombre_admin' => $this->nombre_admin,
                'password' => $this->password,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}