<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Alumno;
class VerificacionUsuarioMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rut;
    public $codigo;
    public $nombreCompleto;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rut, $codigo)
    {
        $this->rut = $rut;
        $this->codigo = $codigo;
        $alumno = Alumno::find($rut);
        $this->nombreCompleto = $alumno
            ? "{$alumno->nombre_alumno} {$alumno->apellido_paterno} {$alumno->apellido_materno}"
            : 'Alumno no encontrado';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verificación de Cuenta')
                    ->view('emails.verificacion_usuario')
                    ->with([
                        'rut' => $this->rut,
                        'codigo' => $this->codigo,
                        'nombreCompleto' => $this->nombreCompleto,
                    ]);
    }
}