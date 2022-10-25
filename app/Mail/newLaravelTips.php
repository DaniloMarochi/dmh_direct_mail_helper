<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class newLaravelTips extends Mailable
{
    use Queueable, SerializesModels;

    private $student;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Student $student)
    {
      $this->student = $student;

    }

    public function build()
    {
        $this->subject('Novo email!');
        $this->to($this->student->email, $this->student->name);

        return $this->markdown('mail.newLaravelTips', [
            'student' => $this->student
        ]);
    }
}
