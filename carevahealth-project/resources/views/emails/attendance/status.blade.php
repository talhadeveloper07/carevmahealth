@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Change Request</title>
    <style>
        body { margin: 0; padding: 0; background: #f4f4f4; font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 6px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .header { background: #0E3180; padding: 20px; text-align: left; color: white; font-size: 22px; font-weight: bold; }
        .header-icon { font-size: 40px; vertical-align: middle; margin-right: 10px; }
        .content { padding: 30px; font-size: 15px; line-height: 1.6; color: #333; }
        .content h2 { color: #006400; margin-bottom: 20px; }
        .btn { display: inline-block; margin: 20px 0; padding: 14px 22px; font-size: 16px; font-weight: bold; color: #0E3180 !important; background: #5AE5F3; border-radius: 6px; text-decoration: none; }
        .footer { background: #f4f4f4; padding: 20px; text-align: center; font-size: 12px; color: #777; }
        .footer a { color: #0E3180; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <span class="header-icon">🕒</span>
            Attendance Request Update
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hello {{ $changeRequest->employee->first_name }},</p>

            <p>Your attendance change request for <strong>{{ Carbon::parse($changeRequest->date)->format('d M Y') }}</strong> has been 
                <strong style="color:{{ $status === 'approved' ? 'green' : 'red' }}">{{ ucfirst($status) }}</strong>.
            </p>

            <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;">
                <tr>
                    <th align="left">Old Clock In</th>
                    <td>{{ $changeRequest->old_clock_in ? Carbon::parse($changeRequest->old_clock_in)->format('h:i A') : '-' }}</td>
                </tr>
                <tr>
                    <th align="left">Old Clock Out</th>
                    <td>{{ $changeRequest->old_clock_out ? Carbon::parse($changeRequest->old_clock_out)->format('h:i A') : '-' }}</td>
                </tr>
                <tr>
                    <th align="left">Requested Clock In</th>
                    <td>{{ $changeRequest->requested_clock_in ? Carbon::parse($changeRequest->requested_clock_in)->format('h:i A') : '-' }}</td>
                </tr>
                <tr>
                    <th align="left">Requested Clock Out</th>
                    <td>{{ $changeRequest->requested_clock_out ? Carbon::parse($changeRequest->requested_clock_out)->format('h:i A') : '-' }}</td>
                </tr>
            </table>

            <p>Thank you,<br>Care VMA Health</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><a href="{{ url('/') }}">Care VMA Health</a></p>
        </div>
    </div>
</body>
</html>
