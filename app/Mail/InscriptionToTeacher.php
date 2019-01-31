<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InscriptionToTeacher extends Mailable
{
    use Queueable, SerializesModels;

    private $course;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($course)
    {
        $this->course = $course;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $course = $this->course;
        return $this->view('mails.inscription_to_teacher', compact('course'))->subject('Inscripción a STARS');
    }
}