<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create Your Account</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .header {
            background: #0E3180;
            padding: 20px;
            text-align: left;
            color: white;
            font-size: 22px;
            font-weight: bold;
        }
        .header-icon {
            font-size: 40px;
            vertical-align: middle;
            margin-right: 10px;
        }
        .content {
            padding: 30px;
            font-size: 15px;
            line-height: 1.6;
            color: #333;
        }
        .content h2 {
            color: #006400;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            margin: 20px 0;
            padding: 14px 22px;
            font-size: 16px;
            font-weight: bold;
            color: #0E3180 !important;
            background: #5AE5F3;
            border-radius: 6px;
            text-decoration: none;
        }
        .footer {
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .footer a {
            color: #0E3180;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <span class="header-icon">👤</span>
            Create Your Account
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hi {{ $employee->first_name }}!</p>

            <p>We’ve created your account. To get started, click the button below and set your password.</p>

            <p><strong>Note:</strong> For security reasons, this link will expire after 24 hours. If it’s already expired, you can request a new one.</p>

            <a href="{{ url('/complete-profile/'.$employee->id) }}" class="btn">Choose Your Password</a>

            <p>Thank you!<br>Care VMA Team</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>If the button above doesn’t work, copy and paste this link into your browser:</p>
            <p><a href="{{ url('/complete-profile/'.$employee->id) }}">{{ url('/complete-profile/'.$employee->id) }}</a></p>
            <p><a href="{{ url('/request-new-link') }}">Request a new link</a></p>
        </div>
    </div>
</body>
</html>
