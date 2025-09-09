<?php

namespace App\Mail;

use App\Models\AttendanceChangeRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AttendanceChangeRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $changeRequest;

    public function __construct(AttendanceChangeRequest $changeRequest)
    {
        $this->changeRequest = $changeRequest;
    }

    public function build()
    {
        return $this->subject('New Employee Attendance Change Request')
            ->view('emails.attendance_change_request');
    }
}
