<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; margin: 0; padding: 0; }
        .invoice-box { width: 100%; padding: 20px; color: #333; }
        .header { border-bottom: 2px solid #0072bc; padding-bottom: 10px; margin-bottom: 20px; }
        .header img { max-height: 50px; }
        .title { font-size: 22px; font-weight: bold; color: #0072bc; }
        .flex { display: flex; justify-content: space-between; align-items: center; }
        .section-title { background: #0072bc; color: #fff; padding: 6px; font-weight: bold; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table th, table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        table th { background: #f2f2f2; }
        .text-right { text-align: right; }
        .total-row td { font-weight: bold; }
        .blue-total { background: #0072bc; color: #fff; font-weight: bold; }
        .account-details p { margin: 2px 0; }
        .note { font-size: 11px; color: #555; margin-top: 10px; }
        .footer { text-align: center; font-weight: bold; color: #0072bc; margin-top: 20px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="invoice-box">

        {{-- Header --}}
        <div class="header flex">
            <div>
                <img src="{{ public_path('images/logo.png') }}" alt="Logo">
                <p class="title">Carevma Health</p>
            </div>
            <div style="text-align:right;">
                <h3 style="margin:0; color:#0072bc;">INVOICE</h3>
            </div>
        </div>

        {{-- Invoice Info --}}
        <div class="flex">
            <div>
                <p><strong>INVOICE #:</strong> {{ $invoice->invoice_number }}</p>
                <p><strong>Date:</strong> {{ $invoice->created_at->format('d F Y') }}</p>
            </div>
            <div style="text-align:right;">
                <p><strong>FOR:</strong> Medical VA Service</p>
                <p><strong>BILL MONTH:</strong> {{ $invoice->period_end->format('F Y') }}</p>
            </div>
        </div>

        {{-- Bill To --}}
        <div class="section-title">BILL TO</div>
        <p>{{ $invoice->client->name }}</p>
        <p>{{ $invoice->client->address ?? '' }}</p>

        {{-- Table --}}
        <div class="section-title">ITEM DESCRIPTION</div>
        <table>
            <thead>
                <tr>
                    <th>VA Name</th>
                    <th>Hours</th>
                    <th>Rate/h</th>
                    <th>From</th>
                    <th>To</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->salaries as $salary)
                <tr>
                    <td>{{ $salary->employee->first_name }} {{ $salary->employee->last_name }}</td>
                    <td>{{ number_format($salary->total_hours, 2) }}</td>
                    <td>${{ number_format($salary->client->per_hour_charges ?? 0, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($salary->period_start)->format('d-M') }}</td>
                    <td>{{ \Carbon\Carbon::parse($salary->period_end)->format('d-M') }}</td>
                    <td class="text-right">${{ number_format($salary->salary_amount, 2) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-right"><strong>Subtotal</strong></td>
                    <td class="text-right">${{ number_format($invoice->salaries->sum('salary_amount'), 2) }}</td>
                </tr>
                <tr class="blue-total">
                    <td colspan="5" class="text-right">TOTAL COST</td>
                    <td class="text-right">${{ number_format($invoice->salaries->sum('salary_amount'), 2) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Payment Info --}}
        <p style="margin-top:20px;">Please pay via Payoneer or to the account given below.</p>
        <div class="section-title">ACCOUNT DETAILS</div>
        <div class="account-details">
            <p><strong>Bank Name:</strong> Citibank</p>
            <p><strong>Bank Address:</strong> 111 Wall Street New York, NY 10043 USA</p>
            <p><strong>Routing (ABA):</strong> 031100209</p>
            <p><strong>SWIFT Code:</strong> CITIUS33</p>
            <p><strong>Account No:</strong> 7508040001159007</p>
            <p><strong>Account type:</strong> CHECKING</p>
            <p><strong>Beneficiary name:</strong> Carevma Health</p>
        </div>

        <p class="note">
            Note: THIS ACCOUNT ONLY ACCEPTS PAYMENTS FROM BUSINESS ACCOUNTS.
            PAYMENTS MADE FROM PERSONAL ACCOUNTS WILL BE RETURNED AUTOMATICALLY.
            FOR PAYING FROM PERSONAL ACCOUNTS PLEASE USE ALTERNATE METHODS.
        </p>

        <div class="footer">THANK YOU FOR YOUR BUSINESS!</div>
    </div>

    {{-- Page Break --}}
    <div class="page-break"></div>

    {{-- Attendance Page --}}
    <div class="invoice-box">
        <h2 style="color:#0072bc;">Attendance Records</h2>

        @foreach($invoice->salaries as $salary)
            <h4>{{ $salary->employee->first_name }} {{ $salary->employee->last_name }}</h4>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Clock In</th>
                        <th>Clock Out</th>
                        <th>Hours Worked</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salary->employee->attendances as $attendance)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d-M-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->clock_out)->format('h:i A') }}</td>
                            <td>@php
                                    $minutes = $attendance->total_minutes; // example
                                    $hours = intdiv($minutes, 60);
                                    $mins = $minutes % 60;
                                @endphp
                                {{ $hours > 0 ? $hours . ' hrs ' : '' }}{{ $mins > 0 ? $mins . ' mins' : '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No attendance records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endforeach
    </div>
</body>
</html>
