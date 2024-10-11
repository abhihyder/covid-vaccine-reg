<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VaccineNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $registration;

    /**
     * Create a new message instance.
     */
    public function __construct($registration)
    {
        $this->registration = $registration;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Vaccine Schedule Reminder')
            ->view('emails.vaccine_notification')
            ->with([
                'registration' => $this->registration,
            ]);
    }
}
