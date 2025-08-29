<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\AttendanceChangeRequest;

class AttendanceStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $status;

    public function __construct(AttendanceChangeRequest $changeRequest, $status)
    {
        $this->changeRequest = $changeRequest;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject("Your Attendance Change Request has been " . ucfirst($this->status))
                    ->view('emails.attendance.status') // 👈 your Blade file
                    ->with([
                        'changeRequest' => $this->changeRequest,
                        'status' => $this->status,
                    ]);
    }
}
