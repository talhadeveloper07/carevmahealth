<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompleteProfileMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;

    /**
     * Create a new message instance.
     */
    public function __construct($employee, $temporaryUrl)
    {
        $this->employee = $employee;
        $this->temporaryUrl = $temporaryUrl;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Complete Your Profile')
                    ->view('emails.complete_profile')
                    ->with([
                        'employee' => $this->employee,
                        'temporaryUrl' => $this->temporaryUrl,
                    ]);
    }

}
